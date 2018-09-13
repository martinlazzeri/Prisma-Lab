<?php
$breadcrumbs = array(
    "Inicio" => APP_URL
);
$page_nav = array(
    "dashboard" => array(
        "title" => "Inicio",
        "icon" => "fa-home",
        "type" => "0",
        "id" => "Inicio"
    ),    
    "proceso-ingreso" => array(
        "title" => "Procesos de Ingresos",
        "icon" => "fa-pencil-square-o",
        "type" => "100",
        "id" => "ProcesosIngresos",
        "sub" => array(
            "ingreso-pacientes" => array(
                'title' => 'Pacientes',
                'icon' => ' fa-group',
                "type" => "101",
                "id" => "IngresosPaciente",
                "sub" => array(
                    "ingreso-normal" => array(
                        "title" => "Ingreso Normal",
                        "icon" => "fa-user",
                        "type" => "102",
                        "id" => "IngresoNormal"
                    ),
                    "ingreso-uno-uno" => array(
                        "title" => "Ingreso Uno a Uno",
                        "icon" => "fa-user",
                        "type" => "103",
                        "id" => "IngresoUnoUno"
                    ), 
                    "reingres" => array(
                        "title" => "Modificar Ingresos",
                        "icon" => "fa-user",
                        "type" => "104",
                        "id" => "ReingresoPaciente"
                    ), 
                    "borrado-normal" => array(
                        "title" => "Borrado Uno a Uno",
                        "icon" => "fa-times",
                        "type" => "105",
                        "id" => "BorradoUnoUno"
                    ), 
                    "listados" => array(
                        "title" => "Listado Normal",
                        "icon" => "fa-list",
                        "type" => "106",
                        "id" => "ListadoNormal"
                    ),
                    "certificado-asistencia" => array(
                        "title" => "Certificado de Asistencia",
                        "icon" => "fa-certificate",
                        "type" => "107",
                        "id" => "CertificadoNormal"
                    )
                )
            ),
            "planillas-trabajo" => array(
                "title" => "Planillas de Trabajo",
                'icon' => 'fa-folder-open',
                "id" => "PlanillasTrabajo",
                "type" => "108",
                "sub" => array(
                    "seccion" => array(
                        "title" => "Por Secci&oacute;n",
                        "icon" => "fa-circle",
                        "type" => "109",
                        "id" => "PlanillaPorSeccion"
                    ),
                    "paciente" => array(
                        "title" => "Por Paciente",
                        "icon" => "fa-user",
                        "type" => "110",
                        "id" => "PlanillaPorPaciente"
                    ),
                    "practica" => array(
                        "title" => "Por Pr&aacute;ctica",
                        "icon" => "fa-flask",
                        "type" => "111",
                        "id" => "PlanillaPorPractica"
                    ),
                    "practicas-diarias" => array(
                        "title" => "Por Pr&aacute;cticas Diarias",
                        "icon" => "fa-calendar",
                        "type" => "112",
                        "id" => "PlanillaPorPracticasDiarias"
                    )
                )
            ),
            "ingreso-resultados" => array(
                "title" => "Ingresar Resultados",
                'icon' => 'fa-folder-open',
                "id" => "IngresoResultados",
                "type" => "113",
                "sub" => array(
                    "resultado-seccion" => array(
                        "title" => "Por Secci&oacute;n",
                        "icon" => "fa-circle",
                        "type" => "114",
                        "id" => "ResultadoPorSeccion"
                    ),
                    "resultado-paciente" => array(
                        "title" => "Por Paciente",
                        "icon" => "fa-user",
                        "id" => "ResultadoPorPaciente",
                        "type" => "115"
                    ),
                    "resultado-practica" => array(
                        "title" => "Por Pr&aacute;ctica",
                        "icon" => "fa-flask",
                        "type" => "116",
                        "id" => "ResultadoPorPractica"
                    )
                )
            ),
            "patologia" => array(
                "title" => "Patolog&iacute;a",
                'icon' => 'fa-folder-open',
                "id" => "Patologia",
                "type" => "118",
                "sub" => array(
                    "analisis-anteriores" => array(
                        "title" => "Pacientes con an&aacute;lisis anteriores",
                        "icon" => "fa-group",
                        "type" => "119",
                        "id" => "AnalisisAnteriores"
                    ),
                    "protocolos-anteriores" => array(
                        "title" => "Protocolos anteriores (uno a uno)",
                        "icon" => "fa-files-o",
                        "type" => "120",
                        "id" => "ProtocolosAnteriores"
                    )
                )
            )
        )
    ),
    "correccion" => array(
        "title" => "Consulta y Correcci&oacute;n",
        "icon" => "fa-pencil",
        "type" => "200",
        "sub" => array(
            "consulta-resultados" => array(
                "title" => "Consultar Resultados Pacientes",
                "icon" => 'fa-folder-open',
                "id" => "ResultadosPacientes",
                "type" => "202"               
            ),
            "calculos-presupuestos" => array(
                "title" => "Calculo de Presupuestos",
                'icon' => 'fa-folder-open',
                "type" => "203",
                "id" => "CalculoPresupuestos"
            ),
            "correcion-resultados" => array(
                "title" => "Correcci&oacute;n de Resultados",
                'icon' => 'fa-folder-open',
                "type" => "204",
                "id" => "CorreccionResultados"
            )
        )
    ),
    "emision-protocolos" => array(
        "title" => "Emisi&oacute;n de Protocolos",
        "icon" => "fa-file-text-o",
        "type" => "300",
        "sub" => array(
            "protocolos-terminados" => array(
                "title" => "Protocolos Terminados",
                'icon' => 'fa-folder-open',
                "type" => "301",
                "id" => "ProtocolosTerminados"
            ),
            "protocolos-uno-uno" => array(
                "title" => "Protocolos Uno a Uno",
                'icon' => 'fa-folder-open',
                "type" => "302",
                "id" => "ProtocolosUnoUno"
            ),
            "entrega-protocolos" => array(
                "title" => "Entrega de Protocolos",
                'icon' => 'fa-folder-open',
                "type" => "303",
                "id" => "EntregaProtocolos"
            ),
            "reemision-protocolos" => array(
                "title" => "Reemisi&oacute;n de Protocolos",
                'icon' => 'fa-folder-open',
                "type" => "304",
                "id" => "ReemisionProtocolos"           
            )
        )   
    ),
    "procesos-cierre" => array(
        "title" => "Procesos de Cierre",
        "icon" => "fa-folder",
        "type" => "400",
        "sub" => array(
            "cierre-diario" => array(
                "title" => "Cierre Diario",
                'icon' => 'fa-folder-open',
                "id" => "CierreDiario",
                "type" => "401",
                "sub" =>array(
                    "alfabetico-pacientes" => array(
                        "title" => "Listado Alfab&eacute;tico de Pacientes",
                        'icon' => 'fa-folder-open',
                        "type" => "402",
                        "id" => "AlfabeticoPacientes"
                    ),
                    "listado-pendientes" => array(
                        "title" => "Listado de Pendientes",
                        'icon' => 'fa-folder-open',
                        "type" => "403",
                        "id" => "ListadoPendientes"
                    ),
                    "listados-protocolos-comprimidos" => array(
                        "title" => "Listado de Protocolos Comprimidos",
                        'icon' => 'fa-folder-open',
                        "type" => "404",
                        "id" => "ListadosProtocolosComprimidos"
                    ),
                    "listado-caja-diaria" => array(
                        "title" => "Listado de Caja Diaria",
                        'icon' => 'fa-folder-open',
                        "type" => "405",
                        "id" => "ListadoCajaDiaria"
                    )
                )
            ),
            "cierre-mensual" => array(
                "title" => "Cierre Mensual",
                'icon' => 'fa-folder-open',
                "type" => "406",
                "id" => "CierreMensual"
            )
        )
    ),
    "mantenimiento-archivos" => array(
        "title" => "Mantenimiento Arch.",
        "icon" => "fa-files-o",
        "type" => "500",
        "sub" => array(
            "nomenclador" => array(
                "title" => "Nomenclador",
                'icon' => 'fa-folder-open',
                "type" => "501",
                "id" => "Nomenclador",
                "sub" => array(
                    "altas" => array(
                                    "title" => "Altas",
                                    "icon" => "fa-circle",
                                     "type" => "502",
                                     "id" => "AltaNomenclador"
                                    ),
                    "modificacion" => array(
                                            "title" => "Modificaciones",
                                            "icon" => "fa-circle",
                                            "type" => "503",
                                            "id" => "ModificacionNomenclador"   
                                            ),
                    "borrado" => array(
                                            "title" => "Borrado",
                                            "icon" => "fa-circle",
                                            "type" => "504",
                                            "id" => "BorradoNomenclador"
                                            ),
                    "listado" => array(
                                            "title" => "Listados",
                                            "icon" => "fa-circle",
                                            "type" => "505",
                                            "id" => "ListadoNomenclador"
                                        )
                ),
            ),
            "nomenclador-especial" => array(
                "title" => "Nomenclador Esp.",
                'icon' => 'fa-plus-square',
                "type" => "530",
                "sub" => array(
                    "altas" => array(
                                    "title" => "Altas",
                                    "icon" => "fa-circle",
                                    "type" => "531",
                                    "id" => "AltaPractica"
                                    ),
                    "modificacion" => array(
                                            "title" => "Modificaciones",
                                            "icon" => "fa-circle",
                                            "type" => "532",
                                            "id" => "ModificacionPractica"
                                            ),
                    "borrado" => array(
                                            "title" => "Borrado",
                                            "icon" => "fa-circle",
                                            "type" => "533",
                                            "id" => "BorradoPractica"
                                            ),
                    "listado" => array(
                                            "title" => "Listados",
                                            "icon" => "fa-circle",
                                            "id" => "ListadoPracticas",
                                            "type" => "534"
                                        )
                )
            ),
            "Secciones" => array(
                "title" => "Secciones",
                'icon' => 'fa-folder-open',
                "id" => "Secciones",
                "type" => "511",
                "sub" => array(
                    "altas" => array(
                                    "title" => "Altas",
                                    "icon" => "fa-circle",
                                    "type" => "512",
                                    "id" => "AltaSeccion"
                                    ),
                    "modificacion" => array(
                                            "title" => "Modificaciones",
                                            "icon" => "fa-circle",
                                            "type" => "513",
                                            "id" => "ModificacionSeccion"
                                            ),
                    "borrado" => array(
                                            "title" => "Borrado",
                                            "icon" => "fa-circle",
                                            "type" => "514",
                                            "id" => "BorradoSeccion"
                                            ),
                    "listado" => array(
                                            "title" => "Listados",
                                            "icon" => "fa-circle",
                                            "type" => "515",
                                            "id" => "ListadoSeccion"
                                            )
                ),
            ),
            "titulos-valores-normales" => array(
                "title" => "T&iacute;tulos y Valores de Referencia",
                "type" => "516",
                "id" => "TitulosValoresNormales",
                'icon' => 'fa-folder-open',
                "sub" => array(
                    "altas" => array(
                                    "title" => "Altas",
                                    "icon" => "fa-circle",
                                    "type" => "517",
                                    "id" => "AltaTitulo"
                                    ),
                    "modificacion" => array(
                                            "title" => "Modificaciones",
                                            "icon" => "fa-circle",
                                            "type" => "518",
                                            "id" => "ModificacionTitulo"
                                            ),
                    "borrado" => array(
                                            "title" => "Borrado",
                                            "icon" => "fa-circle",
                                            "type" => "519",
                                            "id" => "BorradoTitulo"
                                            ),
                    "listado" => array(
                                            "title" => "Listados",
                                            "icon" => "fa-circle",
                                            "id" => "ListadoObraSocial",
                                            "type" => "520",
                                            "id" => "ListadoTitulos"
                                        )
                )
            ),
            "validacion-archivos" => array(
                "title" => "Validaci&oacute;n de Archivos",                
                "id" => "ValidacionArchivos",
                "type" => "521",
                "sub" => array(
                    "nom-secc" => array(
                                    "title" => "Nomenclador / Secciones",
                                    "icon" => "fa-circle",
                                    "type" => "522",
                                    "id" => "ValidacionNomencladorSeccion"
                                    ),
                    "nom-tit" => array(
                                    "title" => "Nomenclador / T&iacute;tulos",
                                    "icon" => "fa-circle",
                                    "type" => "523",
                                    "id" => "ValidacionNomencladorTitulo"
                                    ),
                    ),
            ),
            "nemotecnicos" => array(
                "title" => "Nemot&eacute;cnicos",
                'icon' => 'fa-folder-open',
                "type" => "524",                 
                "id" => "Nemotecnicos"
            ),           
            "calculos" => array(
                "title" => "C&aacute;lculos",
                "type" => "540",
                "id" => "Calculos",
                'icon' => 'fa-folder-open'
            ),
            "valores-unidades" => array(
                "title" => "Valores de Unidades",
                'icon' => 'fa-folder-open', 
                "type" => "546",
                "id" => "ValoresUnidades"
            ),
        ),
    ),
    "configuraciones" => array(
        "title" => "Configuraciones",
        "icon" => "fa-cogs",
        "type" => "700",
        "sub" => array(
            "configuraciones-usuario" => array(
                "type" => "701",
                "title" => "Config. de Usuario",
                "icon" => "fa-cogs",
                "id" => "ConfiguracionesUsuario"
            )
        )        
    ),    
    "medicos" => array(
        "title" => "M&eacute;dicos",
        'icon' => 'fa-stethoscope', 
        "type" => "541",
        "sub" => array(
            "altas" => array(
                            "title" => "Altas",
                            "icon" => "fa-user",
                            "type" => "542",
                            "id" => "AltaMedico"
                            ),
            "modificacion" => array(
                                    "title" => "Modificaciones",
                                    "icon" => "fa-edit",
                                    "type" => "543",
                                    "id" => "ModificacionMedico"
                                    ),
            "borrado" => array(
                                    "title" => "Borrado",
                                    "icon" => "fa-times",
                                    "type" => "544",
                                    "id" => "BorradoMedico"
                                    ),
            "listado" => array(
                                    "title" => "Listados",
                                    "icon" => "fa-list",
                                    "type" => "545",
                                    "id" => "ListadoMedicos"
                                    )
        )
    ),
    "mutuales" => array(
        "title" => "Obras Sociales",
        'icon' => 'fa-plus-square',
        "type" => "525",
        "sub" => array(
            "altas" => array(
                            "title" => "Altas",
                            "icon" => "fa-user",
                            "type" => "526",
                            "id" => "AltaObraSocial"
                            ),
            "modificacion" => array(
                                    "title" => "Modificaciones",
                                    "icon" => "fa-edit",
                                    "type" => "527",
                                    "id" => "ModificacionObraSocial"
                                    ),
            "borrado" => array(
                                    "title" => "Borrado",
                                    "icon" => "fa-times",
                                    "type" => "528",
                                    "id" => "BorradoObraSocial"
                                    ),
            "listado" => array(
                                    "title" => "Listados",
                                    "icon" => "fa-list",
                                    "id" => "ListadoObraSocial",
                                    "type" => "529",
                                )
        )
    ), 
    "pacientes" => array(
        "title" => "Pacientes",
        'icon' => 'fa-group',
        "type" => "800",
        "sub" => array(
            "altas" => array(
                            "title" => "Altas",
                            "icon" => "fa-user",
                            "type" => "802",
                            "id" => "AltaPaciente"
                            ),
            "modificacion" => array(
                                    "title" => "Modificaciones",
                                    "icon" => "fa-edit",
                                    "type" => "804",
                                    "id" => "ModificacionPaciente"
                                    ),
            "borrado" => array(
                                    "title" => "Borrado",
                                    "icon" => "fa-times",
                                    "type" => "806",
                                    "id" => "BorradoPaciente"
                                    ),
            "listado" => array(
                                    "title" => "Listados",
                                    "icon" => "fa-list",
                                    "id" => "ListadoPaciente",
                                    "type" => "808",
                                )
        )
    ),
    "usuarios" => array(
        "title" => "Usuarios",
        "icon" => "fa-group",
        "type" => "600",
        "sub" => array(
            "altas" => array(
                            "title" => "Altas",
                            "icon" => "fa-user",
                            "type" => "602",
                            "id" => "AltaUsuario"
                            ),
            "modificacion" => array(
                                    "title" => "Modificaciones",
                                    "icon" => "fa-edit",                                    
                                    "type" => "604",
                                    "id" => "ModificacionUsuario"
                                    ),
            "borrado" => array(
                                    "title" => "Borrado",
                                    "icon" => "fa-times",                                    
                                    "type" => "606",
                                    "id" => "BorradoUsuario"
                                    ),
            "listado" => array(
                                    "title" => "Listados",
                                    "icon" => "fa-list",                                    
                                    "type" => "608",
                                    "id" => "ListadoUsuario"
                                    )
        )
    ),
    "auditorias" => array(
        "title" => "Auditorias",
        "icon" => "fa-unlock-alt",
        "type" => "600",
        "sub" => array(
            "usuariosActivos" => array(
                            "title" => "Usuarios Activos",
                            "icon" => "fa-circle",
                            "type" => "601",
                            "id" => "UsuariosActivos"
                            ),
            "usuariosInactivos" => array(
                            "title" => "Usuarios Inactivos",
                            "icon" => "fa-circle",
                            "type" => "601",
                            "id" => "UsuariosInactivos"
                            ),
            "usuariosMasFrecuentes" => array(
                            "title" => "Usuarios Más Frecuentes",
                            "icon" => "fa-circle",
                            "type" => "601",
                            "id" => "UsuariosMasFrecuentes"
                            ),
        )
    )
);
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>