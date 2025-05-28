<?php
// src/Model/Product.php

class Product
{
    public static function all()
    {
        return Database::get()
            ->query("SELECT * FROM products")
            ->fetchAll();
    }

    public static function find(int $id)
    {
        $stmt = Database::get()->prepare(
            "SELECT * FROM products WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $stmt = Database::get()->prepare(
            "INSERT INTO products (name, description, price, image)
             VALUES (:name, :desc, :price, :img)"
        );
        return $stmt->execute([
            'name'  => $data['name'],
            'desc'  => $data['description'],
            'price' => $data['price'],
            'img'   => $data['image'],
        ]);
    }

    public static function update(int $id, array $data)
    {
        $stmt = Database::get()->prepare(
            "UPDATE products
                SET name = :name,
                    description = :desc,
                    price = :price,
                    image = :img
              WHERE id = :id"
        );
        return $stmt->execute([
            'id'    => $id,
            'name'  => $data['name'],
            'desc'  => $data['description'],
            'price' => $data['price'],
            'img'   => $data['image'],
        ]);
    }

    public static function delete(int $id)
    {
        $stmt = Database::get()->prepare(
            "DELETE FROM products WHERE id = :id"
        );
        return $stmt->execute(['id' => $id]);
    }
}