<?php
/*
	   PCODER (Editor de Codigo en la Nube)
	   Sistema de Edicion de Codigo basado en PHP
	   Copyright (C) 2013  John F. Arroyave Gutiérrez
						   unix4you2@gmail.com
						   www.practico.org

	 This program is free software: you can redistribute it and/or modify
	 it under the terms of the GNU General Public License as published by
	 the Free Software Foundation, either version 3 of the License, or
	 (at your option) any later version.

	 This program is distributed in the hope that it will be useful,
	 but WITHOUT ANY WARRANTY; without even the implied warranty of
	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 GNU General Public License for more details.

	 You should have received a copy of the GNU General Public License
	 along with this program.  If not, see <http://www.gnu.org/licenses/>
*/

	//Parametros para la configuracion de la base de datos
	$ServidorBD='localhost';	// Direccion IP o nombre de host
	$BaseDatos='pcoder.sdb';   // Path completo cuando se trata de sqlite2, ej: '/path/to/database.sdb'
	$UsuarioBD='root';
	$PasswordBD='mypass';
	$MotorBD='sqlite';		// Puede variar segun el driver PDO: mysql|pgsql|sqlite|sqlsrv|mssql|ibm|dblib|odbc|oracle|ifmx|fbd
	$PuertoBD='';	// Vacio para predeterminado
	$PCODER_TablaUsuariosDDL="
		CREATE TABLE core_usuario (
		  login text PRIMARY KEY,
		  clave text default 'd41d8cd98fd41d8cd98fd41d8cd98fd41d8cd98f',
		  correo text  default ''
		); ";
	$PCODER_TablaUsuarios="core_usuario";


    //Define los modos o lenguajes soportados por el editor
    $PCODER_Modos=array(
	    array(Nombre => "ABAP",	Extensiones => "abap"),
	    array(Nombre => "ActionScript",	Extensiones => "as"),
	    array(Nombre => "ADA",	Extensiones => "ada|adb|ads"),
	    array(Nombre => "Apache_Conf",	Extensiones => "htaccess|htgroups|htpasswd|conf|htaccess|htgroups|htpasswd"),
	    array(Nombre => "AsciiDoc",	Extensiones => "asciidoc|adoc|ans|asc"),
	    array(Nombre => "Assembly_x86",	Extensiones => "asm"),
	    array(Nombre => "AutoHotKey",	Extensiones => "ahk"),
	    array(Nombre => "BatchFile",	Extensiones => "bat|cmd|pif|wsf"),
	    array(Nombre => "C9Search",	Extensiones => "c9search_results"),
	    array(Nombre => "C_Cpp",	Extensiones => "cpp|c|cc|cxx|h|hh|hpp|bcp|tcc"),
	    array(Nombre => "Cirru",	Extensiones => "cirru|cr"),
	    array(Nombre => "Clojure",	Extensiones => "clj|cljs"),
	    array(Nombre => "Cobol",	Extensiones => "CBL|COB"),
	    array(Nombre => "coffee",	Extensiones => "coffee|cf|cson|Cakefile"),
	    array(Nombre => "ColdFusion",	Extensiones => "cfm"),
	    array(Nombre => "CSharp",	Extensiones => "cs|csx"),
	    array(Nombre => "CSS",	Extensiones => "css"),
	    array(Nombre => "Curly",	Extensiones => "curly"),
	    array(Nombre => "D",	Extensiones => "d|di"),
	    array(Nombre => "Dart",	Extensiones => "dart"),
	    array(Nombre => "Diff",	Extensiones => "diff|patch"),
	    array(Nombre => "Dockerfile",	Extensiones => "Dockerfile"),
	    array(Nombre => "Dot",	Extensiones => "dot"),
	    array(Nombre => "Dummy",	Extensiones => "dummy"),
	    array(Nombre => "DummySyntax",	Extensiones => "dummy"),
	    array(Nombre => "Eiffel",	Extensiones => "e"),
	    array(Nombre => "EJS",	Extensiones => "ejs"),
	    array(Nombre => "Elixir",	Extensiones => "ex|exs"),
	    array(Nombre => "Elm",	Extensiones => "elm"),
	    array(Nombre => "Erlang",	Extensiones => "erl|hrl"),
	    array(Nombre => "Forth",	Extensiones => "frt|fs|ldr|4th|forth"),
	    array(Nombre => "FTL",	Extensiones => "ftl"),
	    array(Nombre => "Gcode",	Extensiones => "gcode"),
	    array(Nombre => "Gherkin",	Extensiones => "feature"),
	    array(Nombre => "Gitignore",	Extensiones => "gitignore"),
	    array(Nombre => "Glsl",	Extensiones => "glsl|frag|vert"),
	    array(Nombre => "golang",	Extensiones => "go"),
	    array(Nombre => "Groovy",	Extensiones => "groovy"),
	    array(Nombre => "HAML",	Extensiones => "haml"),
	    array(Nombre => "Handlebars",	Extensiones => "hbs|handlebars|tpl|mustache"),
	    array(Nombre => "Haskell",	Extensiones => "hs|has|lhs|lit"),
	    array(Nombre => "haXe",	Extensiones => "hx"),
	    array(Nombre => "HTML",	Extensiones => "html|htm|xhtml|asp|aspx"),
	    array(Nombre => "HTML_Ruby",	Extensiones => "erb|rhtml"),
	    array(Nombre => "INI",	Extensiones => "ini|cfg|prefs"),
	    array(Nombre => "Io",	Extensiones => "io"),
	    array(Nombre => "Jack",	Extensiones => "jack"),
	    array(Nombre => "Jade",	Extensiones => "jade"),
	    array(Nombre => "Java",	Extensiones => "java"),
	    array(Nombre => "JavaScript",	Extensiones => "js|jsm"),
	    array(Nombre => "JSON",	Extensiones => "json"),
	    array(Nombre => "JSONiq",	Extensiones => "jq"),
	    array(Nombre => "JSP",	Extensiones => "jsp"),
	    array(Nombre => "JSX",	Extensiones => "jsx"),
	    array(Nombre => "Julia",	Extensiones => "jl"),
	    array(Nombre => "LaTeX",	Extensiones => "tex|latex|ltx|bib|sty"),
	    array(Nombre => "LESS",	Extensiones => "less"),
	    array(Nombre => "Liquid",	Extensiones => "liquid"),
	    array(Nombre => "Lisp",	Extensiones => "lisp|lsp"),
	    array(Nombre => "LiveScript",	Extensiones => "ls"),
	    array(Nombre => "LogiQL",	Extensiones => "logic|lql"),
	    array(Nombre => "LSL",	Extensiones => "lsl"),
	    array(Nombre => "Lua",	Extensiones => "lua"),
	    array(Nombre => "LuaPage",	Extensiones => "lp"),
	    array(Nombre => "Lucene",	Extensiones => "lucene"),
	    array(Nombre => "Makefile",	Extensiones => "Makefile|GNUmakefile|makefile|OCamlMakefile|make|am"),
	    array(Nombre => "Markdown",	Extensiones => "md|markdown|markdn"),
	    array(Nombre => "Mask",	Extensiones => "mask"),
	    array(Nombre => "MATLAB",	Extensiones => "matlab"),
	    array(Nombre => "MEL",	Extensiones => "mel"),
	    array(Nombre => "MUSHCode",	Extensiones => "mc|mush"),
	    array(Nombre => "MySQL",	Extensiones => "mysql"),
	    array(Nombre => "Nix",	Extensiones => "nix"),
	    array(Nombre => "ObjectiveC",	Extensiones => "m|mm"),
	    array(Nombre => "OCaml",	Extensiones => "ml|mli"),
	    array(Nombre => "Pascal",	Extensiones => "pas|p|dfm"),
	    array(Nombre => "Perl",	Extensiones => "pl|pm"),
	    array(Nombre => "pgSQL",	Extensiones => "pgsql"),
	    array(Nombre => "PHP",	Extensiones => "php|phtml|inc|ctp|snt"),
	    array(Nombre => "Powershell",	Extensiones => "ps1"),
	    array(Nombre => "Praat",	Extensiones => "praat|praatscript|psc|proc"),
	    array(Nombre => "Prolog",	Extensiones => "plg|prolog"),
	    array(Nombre => "Properties",	Extensiones => "properties"),
	    array(Nombre => "Protobuf",	Extensiones => "proto"),
	    array(Nombre => "Python",	Extensiones => "py"),
	    array(Nombre => "R",	Extensiones => "r"),
	    array(Nombre => "RDoc",	Extensiones => "Rd"),
	    array(Nombre => "RHTML",	Extensiones => "Rhtml"),
	    array(Nombre => "Ruby",	Extensiones => "rb|ru|gemspec|rake|Guardfile|Rakefile|Gemfile"),
	    array(Nombre => "Rust",	Extensiones => "rs"),
	    array(Nombre => "SASS",	Extensiones => "sass"),
	    array(Nombre => "SCAD",	Extensiones => "scad"),
	    array(Nombre => "Scala",	Extensiones => "scala"),
	    array(Nombre => "Scheme",	Extensiones => "scm|rkt"),
	    array(Nombre => "SCSS",	Extensiones => "scss"),
	    array(Nombre => "SH",	Extensiones => "sh|bash|bashrc|bsh"),
	    array(Nombre => "SJS",	Extensiones => "sjs"),
	    array(Nombre => "Smarty",	Extensiones => "smarty|tpl"),
	    array(Nombre => "snippets",	Extensiones => "snippets"),
	    array(Nombre => "Soy_Template",	Extensiones => "soy"),
	    array(Nombre => "Space",	Extensiones => "space"),
	    array(Nombre => "SQL",	Extensiones => "sql|dblib|dblib_mssql|fbd|ibm|ifmx|mssql|odbc|oracle|sqlite|sqlsrv"),
	    array(Nombre => "Stylus",	Extensiones => "styl|stylus"),
	    array(Nombre => "SVG",	Extensiones => "svg"),
	    array(Nombre => "Tcl",	Extensiones => "tcl"),
	    array(Nombre => "Tex",	Extensiones => "tex"),
	    array(Nombre => "Text",	Extensiones => "txt|nfo|dat|inf|log|csv|tab|url|1st|fountain|me|now|readme|rft|cst|pl1|pli|plc|src|swift|tk"),
	    array(Nombre => "Textile",	Extensiones => "textile"),
	    array(Nombre => "Toml",	Extensiones => "toml"),
	    array(Nombre => "Twig",	Extensiones => "twig"),
	    array(Nombre => "Typescript",	Extensiones => "ts|typescript|str"),
	    array(Nombre => "Vala",	Extensiones => "vala"),
	    array(Nombre => "VBScript",	Extensiones => "bas|vbs|vb|b|sb"),
	    array(Nombre => "Velocity",	Extensiones => "vm"),
	    array(Nombre => "Verilog",	Extensiones => "v|vh|sv|svh"),
	    array(Nombre => "VHDL",	Extensiones => "vhd|vhdl"),
	    array(Nombre => "XML",	Extensiones => "xml|rdf|rss|wsdl|xsl|xslt|atom|mathml|mml|xul|xbl"),
	    array(Nombre => "XQuery",	Extensiones => "xq"),
	    array(Nombre => "YAML",	Extensiones => "yaml|yml")
	);


    //Define los temas de color claro disponibles para el editor
    $PCODER_TemasBrillantes=array(
        array(Nombre => "Chrome",	Valor => "chrome"),
        array(Nombre => "Clouds",	Valor => "clouds"),
        array(Nombre => "Crimson Editor",	Valor => "crimson_editor"),
        array(Nombre => "Dawn",	Valor => "dawn"),
        array(Nombre => "Dreamweaver",	Valor => "dreamweaver"),
        array(Nombre => "Eclipse",	Valor => "eclipse"),
        array(Nombre => "GitHub",	Valor => "github"),
        array(Nombre => "Solarized Light",	Valor => "solarized_light"),
        array(Nombre => "TextMate",	Valor => "textmate"),
        array(Nombre => "Tomorrow",	Valor => "tomorrow"),
        array(Nombre => "XCode",	Valor => "xcode"),
        array(Nombre => "Kuroir",	Valor => "kuroir"),
        array(Nombre => "KatzenMilch",	Valor => "katzenmilch")
    );


    //Define los temas de color oscuro disponibles para el editor
    $PCODER_TemasOscuros=array(
        array(Nombre => "Ambiance",	Valor => "ambiance"),
        array(Nombre => "Chaos",	Valor => "chaos"),
        array(Nombre => "Clouds Midnight",	Valor => "clouds_midnight"),
        array(Nombre => "Cobalt",	Valor => "cobalt"),
        array(Nombre => "idle Fingers",	Valor => "idle_fingers"),
        array(Nombre => "krTheme",	Valor => "kr_theme"),
        array(Nombre => "Merbivore",	Valor => "merbivore"),
        array(Nombre => "Merbivore Soft",	Valor => "merbivore_soft"),
        array(Nombre => "Mono Industrial",	Valor => "mono_industrial"),
        array(Nombre => "Monokai",	Valor => "monokai"),
        array(Nombre => "Pastel on dark",	Valor => "pastel_on_dark"),
        array(Nombre => "Solarized Dark",	Valor => "solarized_dark"),
        array(Nombre => "Terminal",	Valor => "terminal"),
        array(Nombre => "Tomorrow Night",	Valor => "tomorrow_night"),
        array(Nombre => "Tomorrow Night Blue",	Valor => "tomorrow_night_blue"),
        array(Nombre => "Tomorrow Night Bright",	Valor => "tomorrow_night_bright"),
        array(Nombre => "Tomorrow Night 80s",	Valor => "tomorrow_night_eighties"),
        array(Nombre => "Twilight",	Valor => "twilight"),
        array(Nombre => "Vibrant Ink",	Valor => "vibrant_ink")
    );
