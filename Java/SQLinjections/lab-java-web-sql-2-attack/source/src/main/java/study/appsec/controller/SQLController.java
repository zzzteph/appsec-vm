package study.appsec.controller;

import com.google.gson.Gson;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import javax.servlet.http.HttpSession;
import study.appsec.db.DatabaseConnection;
import javax.servlet.ServletContext;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import study.appsec.beans.Cart;
import study.appsec.beans.Entry;
import study.appsec.beans.Result;
import study.appsec.beans.Status;

@Controller
public class SQLController {

    @Autowired
    ServletContext context;



    @GetMapping("/")
    public String index(Model model, HttpSession session) {

        Connection con = null;
        Statement stmt = null;
        ResultSet rs = null;
        Double totalPrice = 0.0;

        String query = "SELECT id,name,options,quantity,price from cart";
        model.addAttribute("query", query);
        List<Entry> entries = new ArrayList();
        try {
            con = DatabaseConnection.getInstance().getConnection();
            stmt = con.createStatement();
            rs = stmt.executeQuery(query);

            while (rs.next()) {
                Double productPrice = rs.getInt("price") * rs.getDouble("quantity");
                totalPrice += productPrice;

                entries.add(new Entry(rs.getInt("id"), rs.getString("name"), rs.getString("options"), rs.getDouble("quantity"), productPrice));
            }

        } catch (SQLException sqlEx) {
        } finally {

            try {
                con.close();
            } catch (SQLException se) {
            }
        }
        model.addAttribute("entries", entries);
        model.addAttribute("totalPrice", totalPrice);
        return "index";
    }

}
