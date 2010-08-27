<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Standard inclusions
require_once("pchart-lib/pChart/pData.class.php");
require_once("pchart-lib/pChart/pChart.class.php");

/**
 * CI pchart helper class
 * @author Trieu Nguyen (tantrieuf31@gmail.com)
 */
class ci_pchart {

    const BASE_IMAGES_PATH= "";

    /**
     * __construct
     *
     * @return void
     **/
    public function __construct() {

    }

    public function drawPieChart($data = array()) {
        // Dataset definition
        $DataSet = new pData();
        $DataSet->AddPoint(array(10,10,8,30,5),"Serie1");
        $DataSet->AddPoint(array("January","February","March","April","May"),"Serie2");
        $DataSet->AddAllSeries();
        $DataSet->SetAbsciseLabelSerie("Serie2");

        // Initialise the graph
        $chart = new pChart(450,350);
        $chart->drawFilledRoundedRectangle(7,7,413,243,5,240,240,240);
        $chart->drawRoundedRectangle(5,5,415,245,5,230,230,230);
        $chart->createColorGradientPalette(195,204,56,223,110,41,5);
        $chart->drawBackground(255,255,255);

        // Draw the pie chart
        $chart->setFontProperties("pchart-lib/Fonts/tahoma.ttf",8);
        $chart->AntialiasQuality = 0;
        $chart->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),180,130,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
        $chart->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

        // Write the title
        $chart->setFontProperties("pchart-lib/Fonts/MankSans.ttf",10);
        $chart->drawTitle(10,20,"Sales per month",0,0,0);

        $chart->Render("pchart-lib/images/test-drawPieGraph.jpg");
    }


}
