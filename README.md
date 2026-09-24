# VemSer — tema para Moodle

Tema institucional `theme_vemser`, baseado no Boost, desenvolvido para **Moodle 4.5.5**. Versão atual: **0.1.0 (alpha)**.

Este repositório contém somente o tema. A instalação do Moodle, seu banco de dados, o diretório `moodledata` e suas credenciais não fazem parte dele. O `config.php` presente aqui é a definição do tema exigida pelo Moodle; não é o `config.php` da instalação.

## Recursos

- Login responsivo com imagem institucional, logo e formulário nativo do Moodle.
- Fontes Inter locais e estilos próprios.
- Página inicial pública responsiva com busca de cursos, carrossel manual e rodapé institucional.
- Até quatro destaques com imagem, textos e link configuráveis.
- Dez atalhos de acesso rápido, quatro fornecedores e banner de documentos configuráveis.
- Seis cursos e três avisos reais, com visibilidade controlada pelo Moodle.
- Oito cores da página inicial configuráveis, preservando o visual do login.

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

Acesse **Administração do site → Aparência → Temas → VemSer** para configurar a página pública. Salvar as configurações invalida os caches do tema.

| Área | O que o administrador pode configurar |
| --- | --- |
| Identidade visual | Logo do cabeçalho e do rodapé da página inicial |
| Cores | Cor principal, ícones, texto principal e secundário, fundo da página, seções, cards e texto dos botões |
| Destaques | Imagem, texto superior, título, descrição, botão e destino de até quatro slides |
| Acesso rápido | Nome, imagem e endereço de dez plataformas |
| Fornecedores | Nome, imagem e endereço de quatro parceiros |
| Documentos | Imagem do banner e endereço de destino |
| Navegação e rodapé | Trilhas, listagens de plataformas e fornecedores, privacidade, cookies, suporte e redes sociais |

Use imagens PNG, JPEG ou WebP. Para destaques, prefira imagens horizontais com o assunto principal à direita e espaço à esquerda para o texto. Para logos, use imagens quadradas, preferencialmente com fundo transparente. O banner de documentos usa a imagem à direita.

O primeiro destaque está sempre ativo. Para ativar os demais, preencha seus títulos. As setas e os indicadores aparecem apenas quando existe mais de um slide. O carrossel não avança automaticamente.

Nos atalhos e fornecedores, apagar o nome oculta o card. Um card sem link válido aparece como **Em breve**, sem ação. Links aceitam URLs HTTP(S) completas ou caminhos relativos à instalação iniciados por `/`, como `/course/`. Destinos vazios no rodapé são omitidos. O logo e o fundo do login continuam sendo os arquivos `pix/logo-vemser.png` e `pix/login-background.png`.

### Cursos e avisos

O renderizador da página inicial mostra até **seis cursos** do catálogo, na ordem do Moodle, e **três avisos** do fórum de notícias da página inicial (fixados primeiro, depois mais recentes). O curso do site não é incluído. As regras de visibilidade, permissões, grupos e datas dos avisos são verificadas pelo Moodle.

As seções personalizadas substituem as listas padrão da página inicial, evitando duplicação. Os campos `frontpage`, `frontpageloggedin`, `frontpagecourselimit` e `newsitems` não controlam esses cards. O conteúdo da seção de atividades da página inicial continua disponível pelo fluxo nativo. Não há alteração em matrículas, acesso ao conteúdo dos cursos ou autenticação.

- **Capas dos cursos:** envie a imagem nos arquivos de resumo do cadastro do curso.
- **Imagens dos avisos:** envie uma imagem pelo editor da publicação ou como anexo. A primeira imagem local válida é usada como capa. URLs externas coladas no texto, inclusive links de rascunho de outro Moodle, não são usadas como capas; reenvie essas imagens no Moodle atual.
- Sem imagem, o card usa um ícone substituto. Duração e nível não são inventados: esses metadados ainda não são exibidos.
- A busca do cabeçalho pesquisa o catálogo de cursos.

Para a página ser acessível sem login, mantenha desativada a exigência global de autenticação do Moodle e verifique a visibilidade dos cursos e do fórum para visitantes. O tema não contorna restrições do site. Estes registros e configurações pertencem ao banco de dados e não são incluídos no repositório.

### Cores e acessibilidade

As cores configuráveis se aplicam somente à página inicial. O login finalizado mantém seus estilos. Escolha combinações com contraste adequado, especialmente texto dos botões contra a cor principal. Alterações de cor são validadas como valores hexadecimais de seis dígitos; valores inválidos usam os padrões.

## Estado atual e limitações

- As imagens, os links e os textos institucionais precisam ser configurados pelo administrador para reproduzir a referência visual.
- Não há funcionalidade de favoritos nos cards de cursos.
- O login existente foi preservado; a integração de `standard_end_of_body_html` foi adicionada somente à página inicial.
- As URLs das fontes partem de `/theme/vemser/fonts/`; instalações do Moodle em um subdiretório podem exigir ajuste.

## Organização

- `config.php`: herança do Boost e definição dos layouts.
- `lib.php`: SCSS, entrega dos arquivos configuráveis e preparação dos dados da página inicial.
- `renderers.php`: apresentação das seções públicas no fluxo nativo do Moodle.
- `settings.php`: configurações administrativas.
- `version.php`: identificação e versão do plugin.
- `layout/` e `templates/`: layouts PHP e templates Mustache.
- `scss/`: estilos personalizados.
- `lang/`: textos do plugin.
- `pix/` e `fonts/`: imagens e fontes locais.

## Desenvolvimento

Mantenha o repositório restrito à pasta `theme/vemser`. O `.gitignore` permite na raiz apenas os arquivos e diretórios previstos para o tema, além de excluir arquivos locais, segredos e backups. Ao criar novos diretórios ou arquivos na raiz, atualize essa lista explicitamente.

Não adicione configurações da instalação, credenciais, dumps de banco de dados ou arquivos de usuários. Alterações em PHP, Mustache e SCSS podem exigir a limpeza dos caches do Moodle.

### Convenção de commits

Todos os commits, inclusive o inicial, devem seguir Conventional Commits:

```text
<tipo>[escopo opcional]: <descrição curta em português>
```

Escolha o tipo conforme o objetivo da mudança:

- `feat`: nova funcionalidade.
- `fix`: correção de comportamento.
- `docs`: documentação.
- `style`: formatação do código, sem mudança de comportamento.
- `refactor`: reorganização do código sem nova funcionalidade ou correção.
- `test`: testes.
- `build`: dependências ou processo de compilação.
- `ci`: integração contínua.
- `chore`: manutenção que não se enquadre nos demais tipos.

Mantenha os títulos curtos e em português, preservando os tipos padronizados em inglês. Separe mudanças com objetivos diferentes em commits próprios. Alterações visuais que adicionem funcionalidades ou corrijam problemas devem usar `feat` ou `fix`, conforme o caso.

Exemplos:

```text
feat: adiciona tema VemSer
docs: registra convenção de commits
fix(login): corrige carregamento de scripts
```

Para mudanças incompatíveis, use `!` após o tipo ou escopo e explique o impacto no corpo do commit com `BREAKING CHANGE:`.

Não reescreva commits já publicados. Faça as correções em novos commits; ajustes de histórico ficam restritos a commits ainda locais.
