<?php
namespace Controller;
class AccountController {
    public function create() {
        Echo "criando conta";
    }

    public function show($id) {
        echo "Exibindo conta com ID: " . $id;
    }
}
