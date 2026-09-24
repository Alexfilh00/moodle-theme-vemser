<?php

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

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

    $ADMIN->add('themes', $settings);
}