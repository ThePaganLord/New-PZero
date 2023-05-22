<?php
// Turn off error reporting
error_reporting(0);

$file = $DOCUMENT_ROOT. "https://www.worldometers.info/coronavirus/";
$document = new DOMDocument();
$document->loadHTMLFile($file);

$obj = [];
$jsonObj = [];
$th = $document->getElementsByTagName('th');
$td = $document->getElementsByTagName('td');
$thNum = $th->length;
$arrLength = $td->length;
$rowIx = 0;

for ( $i = 0 ; $i < $arrLength ; $i++){
    $head = $th->item( $i%$thNum )->textContent;
    
    // Get only specific fields to save to json file
    if($head == 'Country,Other'){
        $content = $td->item( $i )->textContent;
        $content=trim($content);        
        $obj[ $head ] = $content;        
    }
    if($head == 'TotalCases'){
        $content = $td->item( $i )->textContent;
        $content=trim($content);
        $obj[ $head ] = $content;  
    }
    if($head == 'NewCases'){
        $content = $td->item( $i )->textContent;
        $content=trim($content);
        $obj[ $head ] = $content;  
    }
    if($head == 'TotalDeaths'){
        $content = $td->item( $i )->textContent;
        $content=trim($content);
        $obj[ $head ] = $content;  
    }
    if($head == 'NewDeaths'){
        $content = $td->item( $i )->textContent;
        $obj[ $head ] = $content;  
    }
    if($head == 'TotalRecovered'){
        $content = $td->item( $i )->textContent;
        $content=trim($content);
        $obj[ $head ] = $content;  
    }

    if( ($i+1) % $thNum === 0){ 
        $jsonObj[++$rowIx] = $obj.',';
        $obj = [];
    }
}

//$storeData = json_encode($jsonObj, JSON_PRETTY_PRINT);
$storeData = json_encode($jsonObj);

$path = 'covid-data.json';
$fp = fopen($path, 'w');
fwrite($fp, $storeData);
fclose($fp);
