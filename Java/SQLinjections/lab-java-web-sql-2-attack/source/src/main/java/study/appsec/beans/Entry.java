package study.appsec.beans;

public class Entry {

    public Integer id;
    public String name;
    public String options;
    public Double quantity;
    public Double price;
// id,name,options,quantity,price

    public Entry(Integer id, String name, String options, Double quantity, Double price) {
        this.id = id;
        this.name = name;
        this.options = options;
        this.quantity = quantity;
        this.price = price;
    }

}
