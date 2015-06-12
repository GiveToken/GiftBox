/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'insert' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		'/',
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	config.extraPlugins = 'colorbutton';
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.

	config.colorButton_foreStyle = {
	    element: 'font',
	    attributes: { 'color': '#(color)' }
	};

	config.colorButton_backStyle = {
	    element: 'font',
	    styles: { 'background-color': '#(color)' }
	};

	config.removeButtons = 'Table,Maximize,Source,Image,Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
