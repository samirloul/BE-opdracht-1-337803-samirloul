-- ****************************************************************************************
-- Project : JaminMagazijn
-- Doel    : Database + tabellen + relaties + seed data
-- Auteur  : <jouw naam>
-- Datum   : <vandaag>
-- ****************************************************************************************

-- ========== Stap 1: Database aanmaken/gebruik ==========
DROP DATABASE IF EXISTS `JaminMagazijn`;
CREATE DATABASE IF NOT EXISTS `JaminMagazijn` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `JaminMagazijn`;

-- Helper: alle tabellen droppen in dependency-volgorde (safe rerun)
DROP TABLE IF EXISTS ProductPerLeverancier;
DROP TABLE IF EXISTS ProductPerAllergeen;
DROP TABLE IF EXISTS Magazijn;
DROP TABLE IF EXISTS Allergeen;
DROP TABLE IF EXISTS Leverancier;
DROP TABLE IF EXISTS Product;

-- ========== Stap 2: Tabellen ==========
-- Product
CREATE TABLE Product
(
    Id                INT UNSIGNED      NOT NULL AUTO_INCREMENT,
    Naam              VARCHAR(100)      NOT NULL,
    Barcode           VARCHAR(13)       NOT NULL,         -- barcode als tekst i.v.m. lengte/leading zeros

    -- systeemvelden
    IsActief          BIT               NOT NULL DEFAULT 1,
    Opmerking         VARCHAR(250)               DEFAULT NULL,
    DatumAangemaakt   DATETIME(6)       NOT NULL,
    DatumGewijzigd    DATETIME(6)       NOT NULL,

    CONSTRAINT PK_Product_Id PRIMARY KEY (Id),
    CONSTRAINT UQ_Product_Barcode UNIQUE (Barcode)
) ENGINE=InnoDB;

-- Allergeen
CREATE TABLE Allergeen
(
    Id                INT UNSIGNED      NOT NULL AUTO_INCREMENT,
    Naam              VARCHAR(100)      NOT NULL,
    Omschrijving      VARCHAR(255)      NOT NULL,

    -- systeemvelden
    IsActief          BIT               NOT NULL DEFAULT 1,
    Opmerking         VARCHAR(250)               DEFAULT NULL,
    DatumAangemaakt   DATETIME(6)       NOT NULL,
    DatumGewijzigd    DATETIME(6)       NOT NULL,

    CONSTRAINT PK_Allergeen_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;

-- Leverancier
CREATE TABLE Leverancier
(
    Id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    Naam                 VARCHAR(100)   NOT NULL,
    ContactPersoon       VARCHAR(100)   NOT NULL,
    LeverancierNummer    VARCHAR(30)    NOT NULL,
    Mobiel               VARCHAR(20)    NOT NULL,

    -- systeemvelden
    IsActief             BIT            NOT NULL DEFAULT 1,
    Opmerking            VARCHAR(250)            DEFAULT NULL,
    DatumAangemaakt      DATETIME(6)    NOT NULL,
    DatumGewijzigd       DATETIME(6)    NOT NULL,

    CONSTRAINT PK_Leverancier_Id PRIMARY KEY (Id),
    CONSTRAINT UQ_LeverancierNummer UNIQUE (LeverancierNummer)
) ENGINE=InnoDB;

-- Magazijn
CREATE TABLE Magazijn
(
    Id                   INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    ProductId            INT UNSIGNED   NOT NULL,
    VerpakkingsEenheidKg DECIMAL(4,1)   NOT NULL,   -- bv. 2.5, 10.0
    AantalAanwezig       INT UNSIGNED            DEFAULT NULL,

    -- systeemvelden
    IsActief             BIT            NOT NULL DEFAULT 1,
    Opmerking            VARCHAR(250)            DEFAULT NULL,
    DatumAangemaakt      DATETIME(6)    NOT NULL,
    DatumGewijzigd       DATETIME(6)    NOT NULL,

    CONSTRAINT PK_Magazijn_Id PRIMARY KEY (Id),
    CONSTRAINT FK_Magazijn_ProductId_Product_Id
        FOREIGN KEY (ProductId) REFERENCES Product(Id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Koppeltabel: ProductPerAllergeen (N:N)
CREATE TABLE ProductPerAllergeen
(
    Id                INT UNSIGNED      NOT NULL AUTO_INCREMENT,
    ProductId         INT UNSIGNED      NOT NULL,
    AllergeenId       INT UNSIGNED      NOT NULL,

    -- systeemvelden
    IsActief          BIT               NOT NULL DEFAULT 1,
    Opmerking         VARCHAR(250)               DEFAULT NULL,
    DatumAangemaakt   DATETIME(6)       NOT NULL,
    DatumGewijzigd    DATETIME(6)       NOT NULL,

    CONSTRAINT PK_ProductPerAllergeen_Id PRIMARY KEY (Id),
    CONSTRAINT FK_PPA_ProductId_Product_Id
        FOREIGN KEY (ProductId) REFERENCES Product(Id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FK_PPA_AllergeenId_Allergeen_Id
        FOREIGN KEY (AllergeenId) REFERENCES Allergeen(Id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT UQ_PPA_Product_Allergeen UNIQUE (ProductId, AllergeenId)
) ENGINE=InnoDB;

-- Koppeltabel: ProductPerLeverancier (N:N met extra velden)
CREATE TABLE ProductPerLeverancier
(
    Id                           INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    LeverancierId                INT UNSIGNED   NOT NULL,
    ProductId                    INT UNSIGNED   NOT NULL,
    DatumLevering                DATE           NOT NULL,
    Aantal                       INT UNSIGNED   NOT NULL,
    DatumEerstVolgendeLevering   DATE                    DEFAULT NULL,

    -- systeemvelden
    IsActief                     BIT            NOT NULL DEFAULT 1,
    Opmerking                    VARCHAR(250)            DEFAULT NULL,
    DatumAangemaakt              DATETIME(6)    NOT NULL,
    DatumGewijzigd               DATETIME(6)    NOT NULL,

    CONSTRAINT PK_ProductPerLeverancier_Id PRIMARY KEY (Id),
    CONSTRAINT FK_PPL_LeverancierId_Leverancier_Id
        FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT FK_PPL_ProductId_Product_Id
        FOREIGN KEY (ProductId) REFERENCES Product(Id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ========== Stap 3: Seed data ==========
-- Producten
INSERT INTO Product (Naam, Barcode, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd) VALUES
('Mintnopjes','8719587231278',1,NULL,SYSDATE(6),SYSDATE(6)),
('Schoolkrijt','8719587326713',1,NULL,SYSDATE(6),SYSDATE(6)),
('Honingdrop','8719587327836',1,NULL,SYSDATE(6),SYSDATE(6)),
('Zure Beren','8719587321441',1,NULL,SYSDATE(6),SYSDATE(6)),
('Cola Flesjes','8719587321237',1,NULL,SYSDATE(6),SYSDATE(6)),
('Turtles','8719587322245',1,NULL,SYSDATE(6),SYSDATE(6)),
('Witte Muizen','8719587328256',1,NULL,SYSDATE(6),SYSDATE(6)),
('Reuzen Slangen','8719587325641',1,NULL,SYSDATE(6),SYSDATE(6)),
('Zoute Rijen','8719587322739',1,NULL,SYSDATE(6),SYSDATE(6)),
('Winegums','8719587327527',1,NULL,SYSDATE(6),SYSDATE(6)),
('Drop Munten','8719587322345',1,NULL,SYSDATE(6),SYSDATE(6)),
('Kruis Drop','8719587322265',1,NULL,SYSDATE(6),SYSDATE(6)),
('Zoute Ruitjes','8719587323256',1,NULL,SYSDATE(6),SYSDATE(6));

-- Allergenen
INSERT INTO Allergeen (Naam, Omschrijving, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd) VALUES
('Gluten','Dit product bevat gluten',1,NULL,SYSDATE(6),SYSDATE(6)),
('Gelatine','Dit product bevat gelatine',1,NULL,SYSDATE(6),SYSDATE(6)),
('AZO-Kleurstof','Dit product bevat AZO-kleurstoffen',1,NULL,SYSDATE(6),SYSDATE(6)),
('Lactose','Dit product bevat lactose',1,NULL,SYSDATE(6),SYSDATE(6)),
('Soja','Dit product bevat soja',1,NULL,SYSDATE(6),SYSDATE(6));

-- Magazijn
INSERT INTO Magazijn (ProductId, VerpakkingsEenheidKg, AantalAanwezig, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd) VALUES
(1, 5.0, 453, 1, NULL, SYSDATE(6), SYSDATE(6)),
(2, 2.5, 400, 1, NULL, SYSDATE(6), SYSDATE(6)),
(3, 5.0,   1, 1, NULL, SYSDATE(6), SYSDATE(6)),
(4, 1.0, 800, 1, NULL, SYSDATE(6), SYSDATE(6)),
(5, 3.0, 234, 1, NULL, SYSDATE(6), SYSDATE(6)),
(6, 2.0, 345, 1, NULL, SYSDATE(6), SYSDATE(6)),
(7, 1.0, 795, 1, NULL, SYSDATE(6), SYSDATE(6)),
(8,10.0, 233, 1, NULL, SYSDATE(6), SYSDATE(6)),
(9, 2.5, 123, 1, NULL, SYSDATE(6), SYSDATE(6)),
(10,3.0, NULL,1, NULL, SYSDATE(6), SYSDATE(6)),
(11,2.0, 367, 1, NULL, SYSDATE(6), SYSDATE(6)),
(12,1.0, 467, 1, NULL, SYSDATE(6), SYSDATE(6)),
(13,5.0,  20, 1, NULL, SYSDATE(6), SYSDATE(6));

-- ProductPerAllergeen
INSERT INTO ProductPerAllergeen (ProductId, AllergeenId, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd) VALUES
(1,2,1,NULL,SYSDATE(6),SYSDATE(6)),
(1,1,1,NULL,SYSDATE(6),SYSDATE(6)),
(1,3,1,NULL,SYSDATE(6),SYSDATE(6)),
(3,4,1,NULL,SYSDATE(6),SYSDATE(6)),
(6,5,1,NULL,SYSDATE(6),SYSDATE(6)),
(9,2,1,NULL,SYSDATE(6),SYSDATE(6)),
(9,5,1,NULL,SYSDATE(6),SYSDATE(6)),
(10,2,1,NULL,SYSDATE(6),SYSDATE(6)),
(12,4,1,NULL,SYSDATE(6),SYSDATE(6)),
(13,1,1,NULL,SYSDATE(6),SYSDATE(6)),
(13,4,1,NULL,SYSDATE(6),SYSDATE(6)),
(13,5,1,NULL,SYSDATE(6),SYSDATE(6));

-- Leveranciers
INSERT INTO Leverancier (Naam, ContactPersoon, LeverancierNummer, Mobiel, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd) VALUES
('Venco','Bert van Linge','L1029384719','06-28493827',1,NULL,SYSDATE(6),SYSDATE(6)),
('Astra Sweets','Jasper del Monte','L1029284315','06-39398734',1,NULL,SYSDATE(6),SYSDATE(6)),
('Haribo','Sven Stalman','L1029324748','06-24383291',1,NULL,SYSDATE(6),SYSDATE(6)),
('Basset','Joyce Stelterberg','L1023845773','06-48293823',1,NULL,SYSDATE(6),SYSDATE(6)),
('De Bron','Remco Veenstra','L1023857736','06-34291234',1,NULL,SYSDATE(6),SYSDATE(6));

-- ProductPerLeverancier (let op: Id's 1..16; één dubbele 14 in brongegevens gecorrigeerd)
INSERT INTO ProductPerLeverancier
(LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd) VALUES
(1,1,  '2024-10-09', 23, '2024-10-16', 1, NULL, SYSDATE(6), SYSDATE(6)),
(1,1,  '2024-10-18', 21, '2024-10-25', 1, NULL, SYSDATE(6), SYSDATE(6)),
(1,2,  '2024-10-09', 12, '2024-10-16', 1, NULL, SYSDATE(6), SYSDATE(6)),
(1,3,  '2024-10-10', 11, '2024-10-17', 1, NULL, SYSDATE(6), SYSDATE(6)),
(2,4,  '2024-10-14', 16, '2024-10-21', 1, NULL, SYSDATE(6), SYSDATE(6)),
(2,4,  '2024-10-21', 23, '2024-10-28', 1, NULL, SYSDATE(6), SYSDATE(6)),
(2,5,  '2024-10-14', 45, '2024-10-21', 1, NULL, SYSDATE(6), SYSDATE(6)),
(2,6,  '2024-10-14', 30, '2024-10-21', 1, NULL, SYSDATE(6), SYSDATE(6)),
(3,7,  '2024-10-12', 12, '2024-10-19', 1, NULL, SYSDATE(6), SYSDATE(6)),
(3,7,  '2024-10-19', 23, '2024-10-26', 1, NULL, SYSDATE(6), SYSDATE(6)),
(3,8,  '2024-10-10', 12, '2024-10-17', 1, NULL, SYSDATE(6), SYSDATE(6)),
(3,9,  '2024-10-11',  1, '2024-10-18', 1, NULL, SYSDATE(6), SYSDATE(6)),
(4,10, '2024-10-16', 24, '2024-10-30', 1, NULL, SYSDATE(6), SYSDATE(6)),
(5,11, '2024-10-10', 47, '2024-10-17', 1, NULL, SYSDATE(6), SYSDATE(6)),
(5,11, '2024-10-19', 60, '2024-10-26', 1, NULL, SYSDATE(6), SYSDATE(6)),
(5,12, '2024-10-11', 45, NULL,        1, NULL, SYSDATE(6), SYSDATE(6)),
(5,13, '2024-10-12', 23, NULL,        1, NULL, SYSDATE(6), SYSDATE(6));
-- ****************************************************************************************
