package study.appsec.controller;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import javax.servlet.http.HttpSession;
import study.appsec.db.DatabaseConnection;
import javax.servlet.ServletContext;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

@Controller
public class SQLController {

    @Autowired
    ServletContext context;

    @PostMapping("/")
    public String login(@RequestParam(name = "login", required = true) String login, @RequestParam(name = "password", required = true) String password, Model model, HttpSession session) {

        Connection con = null;
        Statement stmt = null;
        ResultSet rs = null;

        String query = String.format("select login from users where login='%s' and passwd='%s'", login, password);
        model.addAttribute("query", query);
        System.out.println(query);
        try {
            con = DatabaseConnection.getInstance().getConnection();
            stmt = con.createStatement();
            rs = stmt.executeQuery(query);

            while (rs.next()) {
                model.addAttribute("user", rs.getString(1));
                session.setAttribute("user", rs.getString(1));

            }

        } catch (SQLException sqlEx) {
            sqlEx.printStackTrace();
        } finally {

            try {
                con.close();
            } catch (SQLException se) {
            }
        }

        return index(model, session);
    }

    @GetMapping("/")
    public String index(Model model, HttpSession session) {

        if ((String) session.getAttribute("user") != null) {
            return admin(model, session);
        }
        return "index";
    }

    @GetMapping("/admin")
    protected String admin(Model model, HttpSession session) {

        if ((String) session.getAttribute("user") == null) {
            return index(model, session);
        } else {
            return "admin";
        }

    }

}
