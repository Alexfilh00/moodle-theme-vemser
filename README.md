# VemSer — tema para Moodle

Tema institucional `theme_vemser`, baseado no Boost, desenvolvido para **Moodle 4.5.5**. Versão atual: **0.1.0 (alpha)**.

Este repositório contém somente o tema. A instalação do Moodle, seu banco de dados, o diretório `moodledata` e suas credenciais não fazem parte dele. O `config.php` presente aqui é a definição do tema exigida pelo Moodle; não é o `config.php` da instalação.

## Recursos

- Login responsivo com imagem institucional, logo e formulário nativo do Moodle.
- Fontes Inter locais e estilos próprios.
- Página inicial com cabeçalho e destaque principal configurável.
- Configuração administrativa do logo da página inicial, imagem, textos e botão do destaque.
- Conteúdo nativo da página inicial preservado para cursos e avisos.

## Requisitos

- Instalação funcional do Moodle **4.5.5**, com seus requisitos de PHP e banco de dados atendidos.
- Tema Boost disponível (incluído no Moodle).
- Acesso administrativo ao Moodle e permissão para instalar plugins.

O manifesto declara Moodle 4.5 como versão mínima; isso não representa validação em outras versões. Os arquivos publicados, por si só, não comprovam testes de interface ou autenticação.

## Instalação

1. Baixe o ZIP deste repositório e extraia seu conteúdo.
2. Renomeie a pasta extraída para `vemser` e copie-a para `<MOODLE>/theme/vemser`.
3. Confira a estrutura: `<MOODLE>/theme/vemser/version.php` deve existir, sem uma pasta intermediária adicional.
4. Garanta que o usuário do servidor web tenha permissão de leitura nos arquivos e de acesso aos diretórios.
5. Entre como administrador e acesse **Administração do site → Notificações** para concluir a instalação.
6. Em **Administração do site → Aparência → Temas → Seletor de temas**, selecione **VemSer** como tema padrão.
7. Limpe os caches em **Administração do site → Desenvolvimento → Limpar todos os caches**.

Em Windows + WSL, execute os comandos no terminal WSL, usando os caminhos Linux da instalação. Para a instalação em `/var/www/moodle`, a pasta final é `/var/www/moodle/theme/vemser`.

Opcionalmente, a instalação e a limpeza dos caches podem ser executadas pelo CLI, a partir da raiz do Moodle e com o usuário apropriado do servidor web:

```bash
php admin/cli/upgrade.php
php admin/cli/purge_caches.php
```

Não substitua o `config.php` da raiz do Moodle pelo arquivo deste repositório.

## Configuração

Acesse **Administração do site → Aparência → Temas → VemSer** para configurar o logo da página inicial e o destaque principal. O logo e o fundo do login continuam sendo os arquivos `pix/logo-vemser.png` e `pix/login-background.png`.

Para exibir os cursos e avisos já cadastrados, configure os itens da página inicial para visitantes e usuários autenticados: habilite a lista de cursos e os avisos, permita pelo menos seis cursos no limite de exibição e defina três avisos. Os avisos devem pertencer ao fórum da página inicial; a visibilidade dos cursos e as permissões dos usuários continuam sendo controladas pelo Moodle. Este repositório não inclui esses registros do banco de dados.

## Estado atual e limitações

- Há um único destaque; seus três indicadores são apenas visuais.
- Trilhas, Notícias, Documentos e Plataformas ainda possuem links provisórios (`#`).
- O menu principal é ocultado em telas menores, sem menu móvel substituto.
- Não há cards personalizados de cursos ou avisos.
- Os templates de login e página inicial ainda precisam integrar a saída `standard_end_of_body_html` e validar os comportamentos JavaScript.
- As URLs das fontes partem de `/theme/vemser/fonts/`; instalações do Moodle em um subdiretório podem exigir ajuste.

## Organização

- `config.php`: herança do Boost e definição dos layouts.
- `lib.php`: carregamento do SCSS e entrega dos arquivos configuráveis.
- `settings.php`: configurações administrativas.
- `version.php`: identificação e versão do plugin.
- `layout/` e `templates/`: layouts PHP e templates Mustache.
- `scss/`: estilos personalizados.
- `lang/`: textos do plugin.
- `pix/` e `fonts/`: imagens e fontes locais.

## Desenvolvimento

Mantenha o repositório restrito à pasta `theme/vemser`. O `.gitignore` permite na raiz apenas os arquivos e diretórios previstos para o tema, além de excluir arquivos locais, segredos e backups. Ao criar novos diretórios ou arquivos na raiz, atualize essa lista explicitamente.

Não adicione configurações da instalação, credenciais, dumps de banco de dados ou arquivos de usuários. Alterações em PHP, Mustache e SCSS podem exigir a limpeza dos caches do Moodle.
