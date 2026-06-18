
# 💰 Sistema de Controle Financeiro Pessoal

Sistema web desenvolvido em PHP 8.2 com MySQL e PDO, com interface moderna e responsiva utilizando Bootstrap 5.3.3. Este sistema é voltado para o controle financeiro pessoal, permitindo gerenciar entradas, saídas, categorias de gastos, relatórios, saldo mensal e exportações.

Demonstração: https://financeiro.pedrosilva.tech

## ✅ Funcionalidades

- 🔐 **Autenticação**
  - Login seguro com senha criptografada
  - Sessão protegida com controle de acesso
  - Alteração de senha com verificação

- 💸 **Gestão Financeira**
  - Cadastro de entradas e saídas financeiras
  - Categorização de lançamentos (alimentação, transporte, saúde, etc.)
  - Relatório financeiro mensal e total
  - Visualização de saldo atual, total e por período

- 📊 **Relatórios e Visualização**
  - Gráfico de pizza com distribuição de gastos
  - Gráfico de linha com evolução mensal
  - Exportação de relatórios para PDF e Excel
  - Impressão de extrato

## 🧰 Tecnologias Utilizadas

- **PHP 8.2**
- **MySQL**
- **PDO**
- **Bootstrap 5.3.3**
- **JavaScript (Vanilla)**
- **DomPDF** (para geração de PDF)
- **PhpSpreadsheet** (para exportação em Excel)

## 🛠️ Estrutura do Projeto

```
controle_financeiro/
│
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
│       ├── auth/
│       ├── categorias/
│       ├── lancamentos/
│       └── layouts/
│
├── config/
│   ├── config.php
│   └── Database.php
│
├── public/
│   ├── index.php
│   └── assets/
│
├── vendor/ (Composer)
├── web.php (rotas)
└── README.md
```

## 🚀 Instalação

1. Clone este repositório:
   ```bash
   git clone https://github.com/pedpersil/sistema_financeiro.git
   ```
2. Instale as dependências via Composer:
   ```bash
   composer install
   ```
3. Configure o banco de dados no arquivo `config/config.php`.
4. Importe o script SQL `database/controle_financeiro.sql` no seu MySQL.
5. Acesse no navegador:  
   ```
   http://localhost/controle_financeiro/public
   ```

## 📄 Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

---

Desenvolvido com ❤️ por Pedro Silva – [pedrosilva.tech](https://pedrosilva.tech)
