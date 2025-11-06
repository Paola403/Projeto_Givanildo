# ✅ Sistema de Gerenciamento de Tarefas — Engenharia de Software II

Este diretório contém os arquivos referentes ao desenvolvimento do projeto **To-Do List**, elaborado como atividade prática da disciplina de **Engenharia de Software II** no curso de **Desenvolvimento de Software Multiplataforma** da **FATEC Araras**.

---

## 📘 Descrição Geral

O **To-Do List** é uma aplicação web desenvolvida para o **gerenciamento de tarefas e categorias**.  
O sistema permite ao usuário **criar, editar, excluir e visualizar tarefas**, organizando-as por categorias personalizadas e controlando o status de conclusão.  

O projeto foi desenvolvido aplicando os conceitos de **engenharia de software** e utilizando o **modelo de desenvolvimento incremental**, onde cada entrega adiciona novas funcionalidades e refinamentos.

---

## 🧩 Estrutura da Pasta

```bash
📁 Projeto_Givanildo/
│
├── 📁 documentação/       # Documentação e Diagramas
├── 📁 data/               # Modelos conceitual, lógico e físico + dicionário de dados
├── 📁 config/             # Arquivos de configuração e conexão com o banco (db.php via PDO)
├── 📁 controller/         # Controladores (CategoriaController.php, UserController.php, TarefaController.php)
├── 📁 model/              # Regras de negócio e acesso ao banco de dados
├── 📁 public/             # Arquivos públicos (CSS, JS, imagens, etc.)
│   └── 📁 partials/       # Componentes reutilizáveis (header, navbar, footer)
├── 📁 views/              # Páginas e formulários do sistema
│   ├── 📁 tarefa/         # Telas de gerenciamento de tarefas
│   ├── 📁 categoria/      # Telas de categorias e edição
│   └── 📁 user/           # Telas de login e cadastro
└── README.md              # Documentação principal do projeto
```


---

## ⚙️ Funcionalidades Principais

- Cadastro, edição e exclusão de tarefas  
- Organização de tarefas por categoria  
- Marcação de tarefas concluídas  
- Interface responsiva e intuitiva com **Bootstrap**  
- Armazenamento persistente em banco de dados **MySQL**

---

## 💻 Tecnologias Utilizadas

- **HTML5** — Estrutura e semântica do conteúdo  
- **CSS3** — Estilização e layout responsivo  
- **JavaScript** — Interatividade e manipulação dinâmica da página  
- **Bootstrap 5** — Framework front-end para responsividade  
- **PHP 8** — Lógica de back-end e conexão com o banco de dados  
- **MySQL** — Banco de dados relacional utilizado para armazenar as tarefas e categorias

---

## 🔄 Metodologia de Desenvolvimento

O desenvolvimento seguiu o **modelo incremental**, permitindo que o sistema fosse construído e validado em etapas.  
Cada incremento introduziu novas funcionalidades, resultando em um produto final mais estável e alinhado às necessidades definidas na fase de requisitos.

---

## 🎨 Prototipagem

A prototipagem da interface foi realizada no **Figma**, servindo como base para o desenvolvimento das telas do sistema.  

🔗 **Acesse o protótipo no Figma:**  
[Visualizar no Figma](https://www.figma.com/design/fSt5rfHOjHZcQeda2bdrAg/Trabalho---Engenharia-de-Software?node-id=0-1&p=f&t=yzG3lg8y1RvU5yaF-0)

---

## 🛠️ Ferramentas Utilizadas

- **Visual Studio Code** — Ambiente de desenvolvimento  
- **XAMPP** — Servidor local para execução do PHP e MySQL  
- **PHPMyAdmin** — Gerenciamento do banco de dados  
- **Git e GitHub** — Controle de versão e hospedagem do código  
- **Figma** — Criação e validação do protótipo de interface  

---

## 👩‍💻 Equipe de Desenvolvimento

- [Cauã Porciuncula](https://github.com/Khaleb457) — Desenvolvimento front-end e back-end, integração com banco de dados, e documentação técnica. 
- [Paola Gabriele](https://github.com/Paola403)   — Desenvolvimento front-end, prototipação, criação do banco de dados no MySQL e documentação técnica.  


---

📄 *Este projeto foi desenvolvido como parte das atividades acadêmicas da FATEC Araras — disciplina de Engenharia de Software II.*
