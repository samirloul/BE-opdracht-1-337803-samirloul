USE JaminMagazijn;

-- Overzicht Magazijn: barcode oplopend + benodigde velden voor links
DROP PROCEDURE IF EXISTS usp_MagazijnOverzicht;
DELIMITER //
CREATE PROCEDURE usp_MagazijnOverzicht()
BEGIN
    SELECT 
        p.Id,
        p.Naam,
        p.Barcode,
        m.VerpakkingsEenheidKg,
        m.AantalAanwezig
    FROM Magazijn m
    INNER JOIN Product p ON p.Id = m.ProductId
    ORDER BY p.Barcode ASC;
END //
DELIMITER ;

-- Allergenen per specifiek product (op allergenen-naam oplopend)
DROP PROCEDURE IF EXISTS usp_AllergenenVoorProduct;
DELIMITER //
CREATE PROCEDURE usp_AllergenenVoorProduct(IN pProductId INT)
BEGIN
    SELECT 
        p.Id           AS ProductId,
        p.Naam         AS ProductNaam,
        p.Barcode      AS Barcode,
        a.Naam         AS Allergeen,
        a.Omschrijving AS Omschrijving
    FROM Product p
    LEFT JOIN ProductPerAllergeen ppa ON ppa.ProductId = p.Id
    LEFT JOIN Allergeen a            ON a.Id = ppa.AllergeenId
    WHERE p.Id = pProductId
    ORDER BY a.Naam ASC;
END //
DELIMITER ;

-- Leveringen voor specifiek product (op leverdatum oplopend) + supplier info in de rijen
DROP PROCEDURE IF EXISTS usp_LeveringenVoorProduct;
DELIMITER //
CREATE PROCEDURE usp_LeveringenVoorProduct(IN pProductId INT)
BEGIN
    SELECT
        p.Id  AS ProductId,
        p.Naam AS ProductNaam,
        p.Barcode AS Barcode,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        ppl.DatumLevering,
        ppl.Aantal,
        ppl.DatumEerstVolgendeLevering
    FROM ProductPerLeverancier ppl
    INNER JOIN Product p     ON p.Id = ppl.ProductId
    INNER JOIN Leverancier l ON l.Id = ppl.LeverancierId
    WHERE p.Id = pProductId
    ORDER BY ppl.DatumLevering ASC;
END //
DELIMITER ;
