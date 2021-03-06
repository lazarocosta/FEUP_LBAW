<?php
include_once('../../database/files.php');

function getAuctionId($name, $category, $baseprice, $type, $startingdate, $durationhours, $idowner)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM \"Auction\" WHERE name=? AND category=? AND 
baseprice=? AND type=? AND startingdate=? AND durationhours=? AND idowner=?");
    $stmt->execute(array($name, $category, $baseprice, $type, $startingdate, $durationhours, $idowner));
    return $stmt->fetch()['idauction'];
}

function createAuction($name, $category, $baseprice, $type, $startdate, $time, $description, $state, $idowner)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO \"Auction\" (name,category,baseprice,currentprice,type,startingdate,
durationhours,description,state,idowner) VALUES (?,?,?,0,?,?,?,?,?,?)");
    $stmt->execute(array($name, $category, $baseprice, $type, $startdate, $time, $description, $state, $idowner));
}

function addAuctionPhotos($idauction, $photos)
{

    if (is_array($photos)) {
        foreach ($photos as $photo) {
            if (addFile($photo[0], $photo[1], $photo[2]) != -1) {
                $idfile = getFileId($photo[0], $photo[1]);
                addAImagesAuction($idfile, $idauction);
            }
        }
    } else {
        if (addFile($photos[0], $photos[1], $photos[2]) != -1) {
            $idfile = getFileId($photos[0], $photos[1]);
            addAImagesAuction($idfile, $idauction);
        }
    }
}

function getAuction($idauction)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM \"Auction\" WHERE idauction=?");
    $stmt->execute(array($idauction));
    return $stmt->fetch();
}

function getAuctionComments($idauction)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM \"Comment\" WHERE idauction=?");
    $stmt->execute(array($idauction));
    return $stmt->fetchAll();
}

function getAuctionBids($idauction)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM \"Bid\" WHERE idauction=?");
    $stmt->execute(array($idauction));
    return $stmt->fetchAll();
}

function getAuctionPhotosIDs($idauction)
{
    global $conn;
    $stmt = $conn->prepare("SELECT idfile FROM \"ImagesAuction\" WHERE idauction=?");
    $stmt->execute(array($idauction));
    return $stmt->fetchAll();
}

function getAuctionPhoto($idFile)
{
    global $conn;
    $stmt = $conn->prepare("SELECT path FROM \"File\" WHERE idfile=?");
    $stmt->execute(array($idFile));
    return $stmt->fetch();
}

function auctionsLMO()
{
    global $conn;
    $stmt = $conn->prepare("
        SELECT * FROM \"Auction\" A
        WHERE A.state = 'Opened'::auctionstate
        ORDER BY (A.startingdate + A.durationhours * '1 hour'::interval - current_timestamp) DESC
        LIMIT 12;");
    $stmt->execute(array());
    return $stmt->fetchAll();
}

function auctionsHot()
{
    global $conn;
    $stmt = $conn->prepare("
        SELECT *
        FROM \"Auction\" A
        WHERE  A.state = 'Opened'::auctionstate
        ORDER BY (	SELECT COUNT(*)
        FROM \"Bid\" B 
        WHERE B.idAuction = A.idAuction) 
        DESC, A.name ASC
        LIMIT 12;");
    $stmt->execute(array());
    return $stmt->fetchAll();
}


function createComment($idauction, $iduser, $date, $message)
{

    global $conn;
    $stmt = $conn->prepare("
INSERT INTO \"Comment\" (idauction,iduser,date,message) VALUES(?,?,?,?)");
    $stmt->execute(array($idauction, $iduser, $date, $message));
}
/*
function removeComment($idcomment)
{
    global $conn;
    $stmt = $conn->prepare("
DELETE FROM \"Comment\" WHERE idcomment = ?");
    $stmt->execute(array($idcomment));
}
*/
function editAuctionCategory($idauction, $category)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE \"Auction\" SET category = ?::auctioncategory
WHERE \"Auction\".idauction = ?");
    $stmt->execute(array($idauction, $category));
}

function editAuctionName($idauction, $name)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE \"Auction\" SET name = ?
WHERE \"Auction\".idauction = ?");
    $stmt->execute(array($idauction, $name));
}

function editAuctionDescription($idAuction, $description)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE \"Auction\" SET description = ?
WHERE \"Auction\".idAuction = ?");
    $stmt->execute(array($idAuction, $description));
}

/*Bid*/

function getLastBid($idAuction){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM \"Bid\" WHERE idauction = ? AND ammount IN (SELECT MAX(ammount) FROM
\"Bid\" WHERE idauction = ?)");
    $stmt->execute(array($idAuction,$idAuction));

    return $stmt->fetch();
}

function bidAuction($idauction,$idbidder,$value, $date)
{
    global $conn;

    $lastbid = getLastBid($idauction);

    if (sizeof($lastbid) > 0) {
        if (getLastBid($idauction)['ammount']> $value)
            return -1;
    }

    $stmt = $conn->prepare("INSERT INTO \"Bid\" (idauction,idbidder,ammount,date) VALUES (?,?,?,?)");
    $stmt->execute(array($idauction,$idbidder,$value,$date));

    return 0;
}

