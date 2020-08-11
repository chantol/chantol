
   
    function Convert(N,hasp){
        var m=0;
        var l='';
        if (N >= 1000000){
            m = Math.floor(N / 1000000);
            N = N % 1000000;
            l = l + F_Sevendigit(m)
        }
        if (N >= 100000 && N<1000000){
           m = Math.floor(N / 100000);
            N = N % 100000;
            l = l + F_Sixdigit(m);
        } 
       if (N >= 10000 && N < 100000){
            m = Math.floor(N / 10000);
            N = N % 10000;
            l = l + F_Fivedigit(m);
        } 
        if (N >= 1000 && N < 10000){
            m = Math.floor(N / 1000);
            N = N % 1000;
            l = l + F_Fourdigit(m);
        } 
        
         if (N >= 100 && N < 1000){
            m = Math.floor(N / 100);
            N = N % 100;
            l = l + F_Threedigit(m);
        } 
       
        if (N >= 10 && N < 100){
            m = Math.floor(N / 10);
            N = N % 10;
            l = l + F_twodigit(m);
        } 
        
        if(hasp == true){
             if(N > 0 && N < 10){
                l = l + F_onedigit(N, true);
             }
        }   
        else
        {
            if (N > 0 && N < 10){
                l = l + F_onedigit(N, false);
            }
            
        }
            
        return(l);
    }

    function F_onedigit(N,hasp){
        var F1='';
        if(N == 1){
            F1 = "មួយ";
        }
        else if(N == 2){
            F1 = "ពីរ";
        }
        else if(N == 3){
            F1 = "បី";
        }
        else if(N == 4){
            F1 = "បួន";
        }
        else if(N == 5){
            F1 = "ប្រាំ";
        }
        else if(N == 6){
            F1 = "ប្រាំមួយ";
        }
        else if(N == 7){
            F1 = "ប្រាំពីរ";
        }
        else if(N == 8){
            F1 = "ប្រាំបី";
        }
        else if(N == 9){
            F1 = "ប្រាំបួន";
        }
        else if(N == 0) {
            if(hasp == true) {
                F1 = "សូន្យ";
            }
        }
        return(F1);
     }
    function F_twodigit(N){
        var F2='';
        if(N == 1) {
            F2 = "ដប់";
        }
        else if(N == 2){
            F2 = "ម្ភៃ";
        }
        else if(N == 3){
            F2 = "សាមសិប";
        }
        else if (N == 4){
            F2 = "សែសិប";
        }
        else if (N == 5) {
            F2 = "ហាសិប";
        }
        else if (N == 6) {
            F2 = "ហុកសិប";
        }
        else if (N == 7){
            F2 = "ចិតសិប";
        }
        else if (N == 8){
            F2 = "ប៉ែតសិប";
        }
        else if (N == 9) {
            F2 = "កៅសិប";
        }
        
        return(F2);
    }
    function F_Threedigit(N){
        if(N < 10 && N > 0) {
            return(F_onedigit(N, false) + "រយ");
           return(true);
        }
        return("");
    }
    function F_Fourdigit(N){
        if (N < 10 && N > 0) {
            return(F_onedigit(N, false) + "ពាន់");
            return(true);
        }
        return('');
    }
    function F_Fivedigit(N){
        if (N < 10 && N > 0){
            return(F_onedigit(N, false) + "ម៉ឺន");
            return(true);
        }
        return('');
    }
    function F_Sixdigit(N){
        if(N < 10 && N > 0){
            return(F_onedigit(N, false) + "សែន");
            
        }
        return('');
    }
    function F_Sevendigit(N){
        var m;
        var m1;
        var m2;
        var m3;
        var m4;
        var m5;
        if (N < 10){
            return (F_onedigit(N, false) + "លាន");
        }
        else if (N < 100){
            m = Math.floor(N / 10);
            N = N % 10;
            return(F_twodigit(m) + F_onedigit(N, false) + "លាន");
        }
        else if (N < 1000) {
            m = Math.floor(N / 100);
            m1 = N % 100;
            m2 = Math.floor(m1 / 10);
            m3 = m1 % 10;
            return(F_Threedigit(m) + F_twodigit(m2) + F_onedigit(m3, false) + "លាន");
        }
        else if (N < 10000){
            m = Math.floor(N / 1000);
            m1 = N % 1000;
            m2 = Math.floor(m1 / 100);
            m3 = m1 % 100;
            m4 = Math.floor(m3 / 10);
            m5 = m3 % 10;
            return(F_Fourdigit(m) + F_Threedigit(m2) + F_twodigit(m4) + F_onedigit(m5, false) + "លាន");
        }
        return('');
    }

    function ReadAmount(amt,vCur){
        var str='';
        
        if(amt == ""){
            amt = 0;
        } 
        var f = amt.split('.');
        str = Convert(f[0], false) + vCur;
        
        if (f.length > 1){
            if(f[1] != "") {
                if(f[1].length == 1) {
                    str += "ចុច" + Convert(f[1], true);
                }
                else if(f[1].length == 2){
                    if (f[1].substring(0,1) == 0) {
                        str += "ចុច" + Convert(0, true) + Convert(f[1], true);
                    }
                    else{
                        str += "ចុច" + Convert(f[1], true);
                    }
                }
            }
        }
        return(str);
    }

