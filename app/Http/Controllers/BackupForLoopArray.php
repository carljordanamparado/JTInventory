for($i = 0; $i < count($request -> productCode) ; $i++ ) {

                $product_qty = 0;

                if($request -> productCode[$i] == "C2H2"){
                       $sales_invoice_report = array_add($sales_invoice_report, 'C2H2', $request -> productQty[$i]);
                }
                if($request -> productCode[$i] == "AR"){
                    $sales_invoice_report = array_add($sales_invoice_report, 'AR', $request -> productQty[$i]);
                }
                if($request -> productCode[$i] == "CO2"){
                    $product_qty += intval($request-> productQty[$i]);   
                    $sales_invoice_report = array_add($sales_invoice_report , 'CO2', $product_qty);
                }
                if($request -> productCode[$i] == "IO2"){
                    $sales_invoice_report = array_add($sales_invoice_report, 'IO2', $request -> productQty[$i]);
                }
                if($request -> productCode[$i] == "LPG"){
                    $sales_invoice_report = array_add($sales_invoice_report, 'LPG', $request -> productQty[$i]);
                }
                if($request -> productCode[$i] == "MO2"){
                    $sales_invoice_report = array_add($sales_invoice_report, 'MO2', $request -> productQty[$i]);
                }
                if($request -> productCode[$i] == "N2"){
                    $sales_invoice_report = array_add($sales_invoice_report, 'N2', $request -> productQty[$i]);
                }
                if($request -> productCode[$i] == "N20"){
                    $sales_invoice_report = array_add($sales_invoice_report, 'N20', $request -> productQty[$i]);
                }
                if($request -> productCode[$i] == "H"){
                    $sales_invoice_report = array_add($sales_invoice_report, 'H', $request -> productQty[$i]);
                }
                if($request -> productCode[$i] == "COMPMED"){
                    $sales_invoice_report = array_add($sales_invoice_report, 'COMPMED', $request -> productQty[$i]);
                }

             
            }

            DD($sales_invoice_report);
           dd(array_get($sales_invoice_report, '0'));

            


