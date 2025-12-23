# 🚀 Sistema de Gestão de Clientes (PHP 8 + POO)

Sistema web completo para gerenciamento de clientes e administradores, desenvolvido inicialmente de forma procedural e **totalmente refatorado para Orientação a Objetos (POO)**.

O projeto demonstra a evolução de código legado para uma arquitetura profissional, focando em segurança, manutenibilidade e padrões de projeto.

## 🌟 Destaques da Arquitetura (Refatoração)
Este projeto foi migrado de PHP estruturado para POO para atender padrões de mercado:

- **Encapsulamento:** Conexão com banco e regras de negócio protegidas em Classes (`private`, `public`).
- **Injeção de Dependência:** A conexão PDO é injetada via construtor nas classes `Usuario` e `Cliente`.
- **Single Responsibility (S.O.L.I.D):**
  - `Database.php`: Responsável apenas pela conexão (Padrão Singleton simplificado).
  - `Usuario.php`: Responsável pela autenticação e segurança do admin.
  - `Cliente.php`: Responsável pelo CRUD de clientes.
- **Segurança:** Uso de Prepared Statements em todos os métodos e hash de senha (`password_hash`).

## 🛠️ Tecnologias
- **Back-end:** PHP 8.2 (Vanilla OO)
- **Banco de Dados:** MySQL / MariaDB
- **Front-end:** Bootstrap 5 (Responsivo)
- **Alertas:** SweetAlert2

## ⚙️ Estrutura de Pastas
```text
/
├── classes/          # O Coração do sistema (Models/Services)
│   ├── Database.php  # Conexão segura
│   ├── Usuario.php   # Lógica de Login
│   └── Cliente.php   # Lógica do CRUD
├── includes/         # Componentes visuais e Auth
├── assets/           # CSS/JS customizados
└── index.php         # Controladores (Views)