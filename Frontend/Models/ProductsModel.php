<?php




class ProductsModel{
    public function findCategories($category_id,$pageSize){
        $orderBy = isset($_GET['orderBy'])?$_GET['orderBy']: " ";
        $groupPrice =isset($_GET['groupPrice'])? $_GET['groupPrice']: " ";
        $strGroupPrice="";
        $strOrder="";
        switch ($orderBy){
            case "priceTang";
                $strOrder = " order by price asc ";
                break;
                case "priceGiam";
                    $strOrder = " order by price desc ";
                    break;
            case "A-Z";
                $strOrder = " order by name asc ";
                break;
            case "Z-A";
                $strOrder = " order by name desc ";
                break;
        }

        switch ($groupPrice){
            case "100-400";
                $strGroupPrice = " and price BETWEEN 100000 and 400000 ";
                break;
            case "400-800";
                $strGroupPrice = " and price BETWEEN 100000 and 400000 ";
                break;
            case "800-12000";
                $strGroupPrice = "  and price BETWEEN 100000 and 400000 ";
                break;
            case "all";
             echo "<script>location.href='index.php?controller=Products&action=ProductAll'</script>";
                break;
        }
        if($pageSize > 0)
            $recordPerPage = $pageSize;
        //---
        //phan trang
        //tinh so trang
        //ham ceil la ham lay gia tri tran. vd: 2.3 = 3
        $numPage = ceil($this->totalRecord($category_id)/$recordPerPage);
        //lay bien p truyen tu url
        $p = isset($_GET["p"])&&$_GET["p"] > 0 ? $_GET["p"]-1 : 0;
        //lay tu ban ghi nao
        $from = $p * $recordPerPage;
        $conn = Connection::getInstall();
        $query = $conn->query("select * from products where category_id = $category_id $strGroupPrice $strOrder limit $from,$recordPerPage");
        $result = $query->fetchAll();
        return $result;
    }
    public function totalRecord($category_id){
        //lay bien ket noi
        $conn = Connection::getInstall();
        //thuc hien truy van
        $query = $conn->query("select id from products where status=1 && category_id = $category_id");
        return $query->rowCount();
    }
    public function allProducts($pageSize){
        if($pageSize > 0)
            $recordPerPage = $pageSize;
        //---
        //phan trang
        //tinh so trang
        //ham ceil la ham lay gia tri tran. vd: 2.3 = 3
        $numPage = ceil($this->totalRecord($recordPerPage));
        //lay bien p truyen tu url
        $p = isset($_GET["p"])&&$_GET["p"] > 0 ? $_GET["p"]-1 : 0;
        //lay tu ban ghi nao
        $from = $p * $recordPerPage;
        $conn = Connection::getInstall();
        $query = $conn->query("select * from products where status=1 limit $from,$recordPerPage ");
        $result = $query->fetchAll();
        return $result;
    }
    public function detailProduct($id){
        $conn = Connection::getInstall();
        //thuc hien truy van
        $query = $conn->query("select * from products where status=1 && id = $id");
        return $query->fetch();
    }
    public function totalRecoreProducts(){
        $conn = Connection::getInstall();
        //thuc hien truy van
        $query = $conn->query("select id from products where status=1 ");
        return $query->rowCount();
    }
    public function totalRecordSearch(){
        $key = isset($_GET["key"]) ? $_GET["key"]:"";
        $fromPrice = isset($_GET["fromPrice"]) ? $_GET["fromPrice"]:0;
        $toPrice = isset($_GET["toPrice"]) ? $_GET["toPrice"]:0;
        //---
        $strWhere = "";
        if($fromPrice > 0 && $toPrice > 0)
            $strWhere = " and price BETWEEN $fromPrice and $toPrice ";
        //lay bien ket noi
        $conn = Connection::getInstall();
        //thuc hien truy van
        $query = $conn->query("select id from products where name like '%$key%' $strWhere");
        return $query->rowCount();
    }
    public function modelSearch(){

    }
}









?>