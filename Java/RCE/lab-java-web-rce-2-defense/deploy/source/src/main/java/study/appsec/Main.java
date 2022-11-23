package study.appsec;


import javax.servlet.RequestDispatcher;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.List;
import java.util.UUID;

public class Main extends HttpServlet {

    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {

        String filename="";
        if(req.getParameter("filename")!=null)
        filename=req.getParameter("filename");
       Process proc = Runtime.getRuntime().exec("find /sources/ -name "+filename);


        BufferedReader stdInput = new BufferedReader(new InputStreamReader(proc.getInputStream()));
        BufferedReader stdError = new BufferedReader(new InputStreamReader(proc.getErrorStream()));
        String s;
        StringBuilder output=new StringBuilder();
        while ((s = stdInput.readLine()) != null) {
            output.append(s);
            output.append("<br/>");
               
        }

        while ((s = stdError.readLine()) != null) {
            output.append(s);
            output.append("<br/>");
        }
        req.setAttribute("output", output.toString());
        this.doGet(req,resp);
    }

    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        RequestDispatcher requestDispatcher = req.getRequestDispatcher("/WEB-INF/view/index.jsp");
        requestDispatcher.forward(req, resp);
    }
}
