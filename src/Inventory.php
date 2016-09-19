<?php

    class Inventory
    {
        private $name;
        private $id;
        private $quantity;

        function __construct($name, $quantity, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
            $this->quantity = $quantity;
        }
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }
        function getName()
        {
            return $this->name;
        }
        function getId()
        {
            return $this->id;
        }
        function getQuantity()
        {
            return $this->quantity;
        }
        function setQuantity($new_quantity)
        {
            $this->quantity = $new_quantity;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO inventory (name, quantity) VALUES ('{$this->getName()}',{$this->getQuantity()});");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }
        static function getAll()
        {
            $returned_inventory = $GLOBALS['DB']->query("SELECT * FROM inventory;");
            $inventories = array();
            foreach($returned_inventory as $inventory) {
                $name = $inventory['name'];
                $id = $inventory['id'];
                $quantity = $inventory['quantity'];
                $new_inventory = new Inventory($name, $quantity, $id);
                array_push($inventories, $new_inventory);
            }
            return $inventories;
        }
        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM inventory;");
        }
        static function find($search_id)
        {
            $found_inventory = null;
            $inventories = Inventory::getAll();
            foreach($inventories as $inventory) {
                $inventory_id = $inventory->getId();
                if ($inventory_id == $search_id) {
                  $found_inventory = $inventory;
                }
            }
            return $found_inventory;
        }
        // static function find($search_name)
        // {
        //     $found_inventory = null;
        //     $inventories = Inventory::getAll();
        //     foreach($inventories as $inventory) {
        //         $inventory_name = $inventory->getName();
        //         if ($inventory_name == $search_name) {
        //           $found_inventory = $inventory;
        //         }
        //     }
        //     return $found_inventory;
        // }




    }
 ?>
