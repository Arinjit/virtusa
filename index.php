<?php 
class supermarketcheckout{
    public $totalAcost=0;
    public $totalBcost=0;
    public $totalCcost=0;
    public $totalDcost=0;
    public $totalEcost=0;
    public $totalCost=0;
    function __construct($sku){
        $this->sku=$sku;
        $this->validateSku();
        $this->makeTotal();
    }
    private function validateSku() {
        if(array_key_exists('A', $this->sku)){
            $this->skuA = $this->sku['A'];
            $this->calculateA();
        }if(array_key_exists('B', $this->sku)){
            $this->skuB = $this->sku['B'];
            $this->calculateB();
        }if(array_key_exists('C', $this->sku)){
            $this->skuC = $this->sku['C'];
            $this->calculateC();
        }if(array_key_exists('D', $this->sku)){
            $this->skuD = $this->sku['D'];
            $this->calculateD();
        }if(array_key_exists('E', $this->sku)){
            $this->skuE = $this->sku['E'];
            $this->calculateE();
        }
    }
    private function calculateA(){
        $unit_price=50;
        if($this->skuA>=3){
            //Assuming in case of more than 3 of item A will cost offer price 
            //i.e 130/3 = 43
            $unit_price = 130/3;
        }
        $this->totalAcost=$this->skuA*$unit_price;
    }
    private function calculateB(){
        $unit_price=30;
        if($this->skuB>=2){
            //Assuming in case of more than 2 of item A will cost offer price 
            //i.e 45/2
            $unit_price = 45/2;
        }
        $this->totalBcost=$this->skuB*$unit_price;        
    }
    private function calculateC(){
        $unit_price=20;$least_cost=0;
        if($this->skuC==2){
            //In case qty less than equal 2 calculate unit price    
            //i.e 38/2 
            $unit_price = 38/2;
            $costC=$this->skuC*$unit_price;
        }elseif($this->skuC==1){$costC=$this->skuC*$unit_price;}else{
            $extraC = $this->skuC-3;
            if($extraC>0){
                $extrac_cost = $extraC*$unit_price;
            }
            $least_cost =  3 * (50/3);
            $costC = $least_cost+$extrac_cost;
        }
        $this->totalCcost=$costC;   
    }
    private function calculateD(){
       $unit_price=15; $high_price_D=0;$calcD=0;
        if(!empty($this->skuA)){
            $extraD = $this->skuD - $this->skuA;
            if($extraD<=0){
                //In case of A is more than D
               $unit_price=5;
               $calcD = $this->skuD;
            }
            else {
                //In case of SKU D is more than SKU A
                $high_price_D = $unit_price * $extraD;
                $unit_price=5;
                $calcD = $this->skuD -$extraD;
            }
            $this->totalDcost=$high_price_D+($calcD*$unit_price);
        }else{
            $this->totalDcost=$unit_price*$this->skuD;
        }
    }
    private function calculateE(){
        $unit_price=5;
        $this->totalEcost=$this->skuE*$unit_price;
    }
    
    private function makeTotal() {
        return $this->totalCost = $this->totalAcost+$this->totalBcost+$this->totalCcost+$this->totalDcost+$this->totalEcost;
    }
}

$input_array = array('A'=>6,'B'=>2,'C'=>1,'D'=>3,'E'=>3);//Input array of ITEM [itemname]=>Quantity
$price = new supermarketcheckout($input_array);
?>
<html>
    <head>
        <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
    </head>
    <body>
        <table style="width:50%">
            <tr>
                <th>Product Name</th>
                <th>Qantity</th>
                <th>Cost</th> 
            </tr>
            <?php 
            foreach ($price->sku as $key => $pr) { ?>
            <tr><td>Product <?php echo $key; ?></td><td><?php echo $pr; ?></td><td> <?php $k = 'total'.$key.'cost'; echo $price->$k;?></td></tr>
            <?php }
            ?>
            <tr><td style="border-color: white;"></td><td style="text-align: right;border-color: white;">Grand Total: </td><td style="border-color: white;"><?php echo $price->totalCost; ?></td> 
        </table>
    </body>
</html>