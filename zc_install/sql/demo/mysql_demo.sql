INSERT INTO zones (zone_id,zone_country_id, zone_code, zone_name) VALUES
( NULL,73, '01', 'Ain'),
( NULL,73, '02', 'Aisne'),
( NULL,73, '03', 'Allier'),
( NULL,73, '04', 'Alpes de Haute Provence'),
( NULL,73, '06', 'Alpes Maritimes'),
( NULL,73, '07', 'Ardeche'),
( NULL,73, '08', 'Ardennes'),
( NULL,73, '09', 'Ariege'),
( NULL,73, '10', 'Aube'),
( NULL,73, '11', 'Aude'),
( NULL,73, '12', 'Aveyron'),
( NULL,73, '67', 'Bas Rhin'),
( NULL,73, '13', 'Bouches-du-Rhône'),
( NULL,73, '14', 'Calvados'),
( NULL,73, '15', 'Cantal'),
( NULL,73, '16', 'Charente'),
( NULL,73, '17', 'Charente Maritime'),
( NULL,73, '18', 'Cher'),
( NULL,73, '19', 'Correze'),
( NULL,73, '20', 'Corse'),
( NULL,73, '21', 'Côte-d’Or'),
( NULL,73, '22', 'Côtes-d’Armor'),
( NULL,73, '23', 'Creuse'),
( NULL,73, '79', 'Deux-Sevres'),
( NULL,73, '24', 'Dordogne'),
( NULL,73, '25', 'Doubs'),
( NULL,73, '26', 'Drôme'),
( NULL,73, '91', 'Essonne'),
( NULL,73, '27', 'Eure'),
( NULL,73, '28', 'Eure et Loir'),
( NULL,73, '29', 'Finistere'),
( NULL,73, '30', 'Gard'),
( NULL,73, '32', 'Gers'),
( NULL,73, '33', 'Gironde'),
( NULL,73, '97', 'Guadeloupe'),
( NULL,73, '97', 'Guyane'),
( NULL,73, '68', 'Haut Rhin'),
( NULL,73, '31', 'Haute Garonne'),
( NULL,73, '43', 'Haute Loire'),
( NULL,73, '52', 'Haute Marne'),
( NULL,73, '70', 'Haute-Saône'),
( NULL,73, '74', 'Haute Savoie'),
( NULL,73, '87', 'Haute Vienne'),
( NULL,73, '92', 'Hauts de Seine'),
( NULL,73, '34', 'Herault'),
( NULL,73, '35', 'Ille et Vilaine'),
( NULL,73, '36', 'Indre'),
( NULL,73, '37', 'Indre et Loire'),
( NULL,73, '38', 'Isere'),
( NULL,73, '39', 'Jura'),
( NULL,73, '40', 'Landes'),
( NULL,73, '41', 'Loir et Cher'),
( NULL,73, '42', 'Loire'),
( NULL,73, '44', 'Loire Atlantique'),
( NULL,73, '45', 'Loiret'),
( NULL,73, '46', 'Lot'),
( NULL,73, '47', 'Lot et Garonne'),
( NULL,73, '48', 'Lozere'),
( NULL,73, '49', 'Maine et Loire'),
( NULL,73, '50', 'Manche'),
( NULL,73, '51', 'Marne'),
( NULL,73, '97', 'Martinique'),
( NULL,73, '53', 'Mayenne'),
( NULL,73, '54', 'Meurthe et Moselle'),
( NULL,73, '55', 'Meuse'),
( NULL,73, '98', 'Monaco'),
( NULL,73, '56', 'Morbihan'),
( NULL,73, '57', 'Moselle'),
( NULL,73, '58', 'Nièvre'),
( NULL,73, '59', 'Nord'),
( NULL,73, '60', 'Oise'),
( NULL,73, '61', 'Orne'),
( NULL,73, '75', 'Paris'),
( NULL,73, '62', 'Pas de Calais'),
( NULL,73, '63', 'Puy-de-Dôme'),
( NULL,73, '64', 'Pyrénées-Atlantiques'),
( NULL,73, '66', 'Pyrénées-Orientales'),
( NULL,73, '69', 'Rhône'),
( NULL,73, '71', 'Saône-et-Loire'),
( NULL,73, '72', 'Sarthe'),
( NULL,73, '73', 'Savoie'),
( NULL,73, '77', 'Seine et Marne'),
( NULL,73, '76', 'Seine Maritime'),
( NULL,73, '93', 'Seine Saint Denis'),
( NULL,73, '80', 'Somme'),
( NULL,73, '81', 'Tarn'),
( NULL,73, '82', 'Tarn et Garonne'),
( NULL,73, '90', 'Territoire de Belfort'),
( NULL,73, '95', 'Val d''Oise'),
( NULL,73, '94', 'Val de Marne'),
( NULL,73, '83', 'Var'),
( NULL,73, '84', 'Vaucluse'),
( NULL,73, '85', 'Vendée'),
( NULL,73, '86', 'Vienne'),
( NULL,73, '88', 'Vosges'),
( NULL,73, '89', 'Yonne'),
( NULL,73, '78', 'Yvelines');






ALTER TABLE customers ADD COWOA_account tinyint(1) NOT NULL default 0;
ALTER TABLE orders ADD COWOA_order tinyint(1) NOT NULL default 0;

INSERT INTO configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) 
VALUES 
(NULL, 'Scutephp: Checkout Process', 'Set Checkout Without an Account and Quick Shopping', '1', '1');
SET @configuration_group_id=last_insert_id();

UPDATE configuration_group SET sort_order = @configuration_group_id WHERE configuration_group_id = @configuration_group_id;

INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) 
VALUES 
(NULL, 'Quick Shopping Status', 'COWOA_STATUS', 'true', 'Activate Quick Shopping Checkout? <br />Set to True to allow a customer to checkout without an account.', @configuration_group_id, 10, NOW(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES 
(NULL, 'One Or Two Shopping payment', 'COWOA_ONE_OR_TWO', 'one', 'Set to how to payment.', @configuration_group_id, 10, NOW(), NULL, 'zen_cfg_select_option(array(\'one\', \'two\'),');

INSERT INTO `admin_pages` (`page_key`, `language_key`, `main_page`, `page_params`, `menu_key`, `display_on_menu`, `sort_order`) VALUES
('configCheckoutProcess', 'BOX_CONFIGURATION_CHECK_PROCESS', 'FILENAME_CONFIGURATION', concat('gID=', @configuration_group_id), 'configuration', 'Y', @configuration_group_id);


UPDATE configuration SET configuration_value = 'True' WHERE configuration_title = 'Use split-login page';