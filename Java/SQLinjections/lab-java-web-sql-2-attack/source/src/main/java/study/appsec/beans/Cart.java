package study.appsec.beans;





public class Cart
{

String status="";
Integer sum=0;
Integer sumAfterCheck=0;
String text="";

public Cart(String status,Integer sum,Integer sumAfterCheck)
{
this.status=status;
this.sum=sum;
this.sumAfterCheck=sumAfterCheck;
if(sumAfterCheck==0)
this.text="Flag : not_easy_sql_injection";

}


}


