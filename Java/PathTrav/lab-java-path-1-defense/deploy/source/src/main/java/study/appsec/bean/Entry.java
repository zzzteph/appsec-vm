package study.appsec.bean;

public class Entry {
   public  String name;
    public String link;
    public boolean isFolder;
    public  Entry(String name, boolean isFolder, String link)
    {
        this.name=name;
        this.link=link;
        this.isFolder=isFolder;

    }

}
