<?php 
// Start session 
if(!session_id()){ 
    session_start(); 
} 
 
class Cart { 
    protected $cart_contents = array(); 
    
    public function __construct(){ 
        // Recup tableau cart_contents
        $this->cart_contents = !empty($_SESSION['cart_contents'])?$_SESSION['cart_contents']:NULL; 
        if ($this->cart_contents === NULL){ 
            // Si cart_contents est vide 
            $this->cart_contents = array('cart_total' => 0, 'total_items' => 0); 
        } 
    }
     
    /** 
     * Cart Contents: Retourne le contenu du panier
     * @param    bool 
     * @return    array 
     */ 
    public function contents(){ 
        // Inverse le tableau (dernier ajout passe premier)
        $cart = array_reverse($this->cart_contents); 
 
        // remove these so they don't create a problem when showing the cart table 
        unset($cart['total_items']); 
        unset($cart['cart_total']); 
 
        return $cart; 
    } 
     
    /** 
     * Get cart item: Retourne les details d'un produit du panier
     * @param    string    $row_id 
     * @return    array 
     */ 
    public function get_item($row_id){ 
        return (in_array($row_id, array('total_items', 'cart_total'), TRUE) OR ! isset($this->cart_contents[$row_id])) 
            ? FALSE 
            : $this->cart_contents[$row_id]; 
    } 
     
    /** 
     * Total Items: Returns the total item count 
     * @return    int 
     */ 
    public function total_items(){ 
        return $this->cart_contents['total_items']; 
    } 
     
    /** 
     * Cart Total: Retourne prix total du panier
     * @return    int 
     */ 
    public function total(){ 
        return $this->cart_contents['cart_total']; 
    } 
     
    /** 
     * Ajoute un produit dans le panier et sauvegarde dans session
     * @param    array 
     * @return    bool 
     */ 
    public function insert($item = array()){ 
        if(!is_array($item) OR count($item) === 0){ 
            return FALSE; 
        }else{ 
            if(!isset($item['id'], $item['name'], $item['price'], $item['qty'])){ 
                return FALSE; 
            }else{ 
                /* 
                 * Insert Item 
                 */ 
                // Set price and quantity
                $item['qty'] = (float) $item['qty']; 
                if($item['qty'] == 0){ 
                    return FALSE; 
                } 
                $item['price'] = (float) $item['price']; 
                // Creer un id unique pour le produit a inserer dans le panier 
                $rowid = md5($item['id']); 
                // recupere la quantité si le produit est deja dans le panier et ajoute la nouvelle quantité 
                $old_qty = isset($this->cart_contents[$rowid]['qty']) ? (int) $this->cart_contents[$rowid]['qty'] : 0; 
                // update row id et qty, ecrase ou créer l'entré rowid 
                $item['rowid'] = $rowid; 
                $item['qty'] += $old_qty; 
                $this->cart_contents[$rowid] = $item; 
                 
                // save Cart Item 
                if($this->save_cart()){ 
                    return isset($rowid) ? $rowid : TRUE; 
                }else{ 
                    return FALSE; 
                } 
            } 
        } 
    } 
     
    /** 
     * Mise a jour panier
     * @param    array 
     * @return    bool 
     */ 
    public function update($item = array()){ 
        if (!is_array($item) OR count($item) === 0){ 
            return FALSE; 
        }else{ 
            if (!isset($item['rowid'], $this->cart_contents[$item['rowid']])){ 
                return FALSE; 
            }else{ 
                // prep the quantity 
                if(isset($item['qty'])){ 
                    $item['qty'] = (float) $item['qty']; 
                    // remove the item from the cart, if quantity is zero 
                    if ($item['qty'] == 0){ 
                        unset($this->cart_contents[$item['rowid']]); 
                        return TRUE; 
                    } 
                }
                 
                // find updatable keys 
                $keys = array_intersect(array_keys($this->cart_contents[$item['rowid']]), array_keys($item)); 
                // prep the price 
                if(isset($item['price'])){ 
                    $item['price'] = (float) $item['price']; 
                } 
                // product id & name shouldn't be changed 
                foreach(array_diff($keys, array('id', 'name')) as $key){ 
                    $this->cart_contents[$item['rowid']][$key] = $item[$key]; 
                } 
                // save cart data 
                $this->save_cart(); 
                return TRUE; 
            } 
        } 
    } 

    /** 
     * Save the cart array to the session 
     * @return    bool 
     */
    protected function save_cart(){ 
        $this->cart_contents['total_items'] = $this->cart_contents['cart_total'] = 0; 
        foreach ($this->cart_contents as $key => $val){ 
            // make sure the array contains the proper indexes 
            if(!is_array($val) OR !isset($val['price'], $val['qty'])){ 
                continue; 
            } 
      
            $this->cart_contents['cart_total'] += ($val['price'] * $val['qty']); 
            $this->cart_contents['total_items'] += $val['qty']; 
            $this->cart_contents[$key]['subtotal'] = ($this->cart_contents[$key]['price'] * $this->cart_contents[$key]['qty']); 
        } 
         
        // if cart empty, delete it from the session 
        if(count($this->cart_contents) <= 2){ 
            unset($_SESSION['cart_contents']); 
            return FALSE; 
        }else{ 
            $_SESSION['cart_contents'] = $this->cart_contents; 
            return TRUE; 
        } 
    } 
     
    /** 
     * Remove Item: Removes an item from the cart 
     * @param    int 
     * @return    bool 
     */ 
     public function remove($row_id){ 
        // unset & save 
        unset($this->cart_contents[$row_id]); 
        $this->save_cart(); 
        return TRUE; 
     } 
      
    /** 
     * Destroy the cart: Empties the cart and destroy the session 
     * @return    void 
     */ 
    public function destroy(){ 
        $this->cart_contents = array('cart_total' => 0, 'total_items' => 0); 
        unset($_SESSION['cart_contents']); 
    } 
}