package study.appsec.controller;
import study.appsec.bean.Entry;
import org.springframework.core.io.ClassPathResource;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import javax.servlet.ServletContext;
import org.springframework.beans.factory.annotation.Autowired;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.List;
import java.util.Set;

@Controller
public class MainController {
    @Autowired
    ServletContext context;

    String buildLink(String path) throws IOException
    {

      return path.replace(new ClassPathResource("static/files").getFile().getAbsolutePath(),"");
    }


    @GetMapping("/")
    public String navigate(
            @RequestParam(name="path", required=false, defaultValue="/") String path,
            @RequestParam(name="action", required=false,defaultValue="") String action, Model model) throws IOException {


      String folderSearch="";

      folderSearch=new ClassPathResource("static/files").getFile().getAbsolutePath();
              if(action.equalsIgnoreCase("view"))
        {

            StringBuilder sb = new StringBuilder();
          if(new File(folderSearch,path).isFile()) {
            if(new File(folderSearch,path).getCanonicalPath().equals("/etc/passwd")) {

              model.addAttribute("flag", "You_Found_ME(!)");
            }


              BufferedReader br = new BufferedReader(new FileReader(new File(folderSearch, path).getAbsolutePath()));

              try {

                  String line;

                  while ((line = br.readLine()) != null) {
                      sb.append(line);
                      sb.append(System.lineSeparator());
                  }

              } catch (IOException e) {

              } finally {
                  br.close();
              }
          }
            model.addAttribute("file", sb.toString());
            model.addAttribute("path", new File(folderSearch, path).getAbsolutePath());
            return "file";
        }
        else
        {
            String tmpPath=folderSearch;
            String parent="";

            List<Entry> fEntries=new ArrayList<Entry>();
            if(Files.exists(Paths.get(new File(folderSearch, path).getAbsolutePath())))
            {
                tmpPath=new File(folderSearch, path).getAbsolutePath();
                if(!(tmpPath.equalsIgnoreCase(folderSearch))) {
                    try {
                        String upperFolder = new File(folderSearch, path).getParent().replace(folderSearch, "");
                        fEntries.add(new Entry("..", true, "?path=" + upperFolder));
                    }
                    catch(Exception e) {
                        System.out.println(e.getMessage());
                    }
                }
            }
            for (final File fileEntry : new File(tmpPath).listFiles()) {
                if(fileEntry.isDirectory())
                {
                    fEntries.add(new Entry(fileEntry.getName(),true,"?path="+this.buildLink(fileEntry.getAbsolutePath())));
                }
                else
                {
                    fEntries.add(new Entry(fileEntry.getName(),false,"?action=view&path="+this.buildLink(fileEntry.getAbsolutePath())));
                }
            }
            model.addAttribute("entries", fEntries);
        }

        return "index";

    }

}
