<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    **/

    require_once "src/Inventory.php";

    $server = 'mysql:host=localhost;dbname=inventories_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class InventoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Inventory::deleteAll();
        }

        function test_getName()
        {
            // Arrange
            $name = "Green";
            $quantity = 8;
            $test_Inventory = new Inventory($name, $quantity);
            // Act
            $result = $test_Inventory->getName();
            // Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Blue";
            $quantity = 7;
            $id = 1;
            $test_Inventory = new Inventory($name, $quantity, $id);

            //Act
            $result = $test_Inventory->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Red";
            $quantity = 9;
            $test_Inventory = new Inventory($name, $quantity);
            $test_Inventory->save();

            //Act
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals($test_Inventory, $result[0]);
        }

        function test_getAll()
        {
            $name = "Gray";
            $name2 = "Pink";
            $quantity = 4;
            $quantity2 = 3;
            $test_Inventory = new Inventory($name, $quantity);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($name2, $quantity2);
            $test_Inventory2->save();

            //Act
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals([$test_Inventory, $test_Inventory2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Gray";
            $name2 = "Pink";
            $quantity = 4;
            $quantity2 = 3;
            $test_Inventory = new Inventory($name, $quantity);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($name2, $quantity2);
            $test_Inventory2->save();

            //Act
            Inventory::deleteAll();
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Gray";
            $name2 = "Pink";
            $quantity = 4;
            $quantity2 = 3;
            $test_Inventory = new Inventory($name, $quantity);
            $test_Inventory->save();
            $test_Inventory2 = new Inventory($name2, $quantity2);
            $test_Inventory2->save();

            //Act
            $result = Inventory::find($test_Inventory->getId());

            //Assert
            $this->assertEquals($test_Inventory, $result);
        }
    }
 ?>
