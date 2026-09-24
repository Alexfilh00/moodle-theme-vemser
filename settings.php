<?php

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    require_once(__DIR__ . '/lib.php');

    $settings = new admin_settingpage(
        'themesettingvemser',
        get_string('configtitle', 'theme_vemser')
    );


    // =========================================================
    // IDENTIDADE VISUAL
    // =========================================================

    $settings->add(new admin_setting_heading(
        'theme_vemser/identity',
        'Identidade visual',
        'Configurações gerais da identidade visual do VemSer.'
    ));

    $settings->add(new admin_setting_configstoredfile(
        'theme_vemser/logo',
        'Logo principal',
        'Logo utilizada no cabeçalho da plataforma.',
        'logo'
    ));


    // =========================================================
    // PÁGINA INICIAL
    // =========================================================

    $settings->add(new admin_setting_heading(
        'theme_vemser/homepage',
        'Página inicial',
        'Configurações da página inicial pública do VemSer.'
    ));


    // =========================================================
    // DESTAQUE PRINCIPAL
    // =========================================================

    $settings->add(new admin_setting_heading(
        'theme_vemser/slide1heading',
        'Destaque principal',
        'Configure o primeiro destaque da página inicial.'
    ));

    $settings->add(new admin_setting_configstoredfile(
        'theme_vemser/slide1image',
        'Imagem do destaque',
        'Imagem exibida no destaque principal.',
        'slide1image'
    ));

    $settings->add(new admin_setting_configtext(
        'theme_vemser/slide1eyebrow',
        'Texto superior',
        'Pequeno texto exibido acima do título.',
        'PESSOAS QUE CONSTROEM O AMANHÃ',
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configtext(
        'theme_vemser/slide1title',
        'Título',
        'Título principal do destaque.',
        'Desenvolvimento que transforma realidades.',
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configtextarea(
        'theme_vemser/slide1description',
        'Descrição',
        'Descrição apresentada abaixo do título.',
        'Conhecimento, oportunidades e pessoas para construirmos, juntos, grandes conquistas.',
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configtext(
        'theme_vemser/slide1button',
        'Texto do botão',
        'Texto apresentado no botão.',
        'Explorar cursos',
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configtext(
        'theme_vemser/slide1url',
        'Link do botão',
        'Destino do botão do destaque.',
        '/course/',
        PARAM_RAW_TRIMMED
    ));


    $settings->add(new admin_setting_heading('theme_vemser/homecolours',
        'Cores da página inicial', 'Estas cores não alteram o login. Use cores com contraste adequado entre texto e fundo.'));
    foreach ([
        'homeprimary' => ['Cor principal', '#ff6500'],
        'homeaccent' => ['Ícones e destaques', '#ffa300'],
        'hometext' => ['Texto principal', '#17202d'],
        'homemuted' => ['Texto secundário', '#626975'],
        'homebackground' => ['Fundo da página', '#ffffff'],
        'homesurface' => ['Fundo das seções', '#f4f6f8'],
        'homecard' => ['Fundo dos cards', '#ffffff'],
        'homebuttontext' => ['Texto dos botões', '#ffffff'],
    ] as $key => [$label, $default]) {
        $setting = new admin_setting_configcolourpicker('theme_vemser/' . $key, $label, '', $default);
        $settings->add($setting);
    }

    $settings->add(new admin_setting_heading('theme_vemser/otherslides',
        'Outros destaques', 'Até quatro destaques. Preencha o título para ativar cada slide adicional.'));
    for ($i = 2; $i <= 4; $i++) {
        $key = 'slide' . $i;
        $settings->add(new admin_setting_configstoredfile('theme_vemser/' . $key . 'image',
            'Destaque ' . $i . ': imagem', 'Envie uma imagem horizontal.', $key . 'image', 0,
            ['accepted_types' => ['.png', '.jpg', '.jpeg', '.webp']]));
        foreach (['eyebrow' => 'Texto superior', 'title' => 'Título', 'description' => 'Descrição',
                'button' => 'Texto do botão', 'url' => 'Link do botão'] as $field => $label) {
            $settings->add(new admin_setting_configtext('theme_vemser/' . $key . $field,
                'Destaque ' . $i . ': ' . $label, '', '', $field === 'url' ? PARAM_RAW_TRIMMED : PARAM_TEXT));
        }
    }

    foreach (theme_vemser_home_link_defaults() as $group => $names) {
        $label = $group === 'quick' ? 'Acesso rápido' : 'Fornecedores';
        $settings->add(new admin_setting_heading('theme_vemser/' . $group . 'heading', $label,
            'Configure nome, imagem e endereço de cada card. Deixe o nome vazio para ocultar. '
            . 'Sem endereço, o card aparece como “Em breve”. Links aceitam https:// ou caminho local iniciado por /.'));
        foreach ($names as $index => $default) {
            $key = $group . ($index + 1);
            $prefix = $label . ' ' . ($index + 1) . ': ';
            $settings->add(new admin_setting_configtext('theme_vemser/' . $key . 'name',
                $prefix . 'nome', '', $default, PARAM_TEXT));
            $settings->add(new admin_setting_configtext('theme_vemser/' . $key . 'url',
                $prefix . 'link', '', '', PARAM_RAW_TRIMMED));
            $settings->add(new admin_setting_configstoredfile('theme_vemser/' . $key . 'image',
                $prefix . 'imagem', 'Logo ou ícone do card.', $key . 'image', 0,
                ['accepted_types' => ['.png', '.jpg', '.jpeg', '.webp']]));
        }
    }
    $settings->add(new admin_setting_heading('theme_vemser/documentsheading',
        'Documentos e navegação', 'Configure os destinos e o banner de documentos. Links vazios não criam atalhos sem destino.'));
    $settings->add(new admin_setting_configstoredfile('theme_vemser/documentsimage',
        'Imagem do banner de documentos', 'Envie uma imagem horizontal.', 'documentsimage', 0,
        ['accepted_types' => ['.png', '.jpg', '.jpeg', '.webp']]));
    foreach (['documentsurl' => 'Documentos', 'trailsurl' => 'Trilhas', 'platformsurl' => 'Todas as plataformas',
            'suppliersurl' => 'Todos os fornecedores', 'privacyurl' => 'Política de privacidade',
            'cookiesurl' => 'Aviso de cookies', 'supporturl' => 'Suporte', 'instagramurl' => 'Instagram',
            'linkedinurl' => 'LinkedIn', 'youtubeurl' => 'YouTube'] as $key => $label) {
        $settings->add(new admin_setting_configtext('theme_vemser/' . $key, 'Link: ' . $label,
            'URL HTTP(S) ou caminho local iniciado por /.', '', PARAM_RAW_TRIMMED));
    }

    foreach ($settings->settings as $setting) {
        $setting->set_updatedcallback('theme_reset_all_caches');
    }
    // Moodle adds this settings page to the themes category.
}