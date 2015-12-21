<?php
/**
 * Highcharts用
 **/
class graphData{
    
    private $title = array('text' => '');
    private $xAxis = array('categories' => array());//@var string : 横軸
    private $yAxis = array(//@var array  : 縦軸
            'title'     => array('text' => '貢献度'),
            'plotLines' => array(
                    array('value' => 0,'width' => 1,'color' => '#808080')
                )
        );
    private $legend = array(
            'layout' => 'vertical',
            'align' => 'right',
            'verticalAlign' => 'middle',
            'borderWidth' => 0
        );
    private $series = array();
    private $seriesCount = 0;
    
    /**
     *横軸配列がすべての基本となるので注意
     */
    public function __construct($xAxis = array()){
        $this->xAxis['categories'] = $xAxis;
        $this->seriesCount = count($xAxis);
    }
    
    //gDに直接つめないように
    private function createGdArray(){
         return array(
                'title'  => $this->title,
                'xAxis'  => $this->xAxis,
                'yAxis'  => $this->yAxis,
                'legend' => $this->legend,
                'series' => $this->series
            );
    }
    
    public function getviewData(){
        return $this->createGdArray();
    }
    
    public function setSeries($name, array $data){
        if($this->seriesCount != count($data))return false;
        $this->series[] = array('name' => $name, 'data' => $data);
    }

}
?>