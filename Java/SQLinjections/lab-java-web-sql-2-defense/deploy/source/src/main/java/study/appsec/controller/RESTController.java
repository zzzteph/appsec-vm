/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package study.appsec.controller;

import com.google.gson.Gson;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import javax.servlet.http.HttpSession;
import org.springframework.http.MediaType;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import study.appsec.beans.Cart;
import study.appsec.beans.Result;
import study.appsec.beans.Status;
import study.appsec.db.DatabaseConnection;

/**
 *
 * @author steph
 */
@RestController
public class RESTController {

    @RequestMapping(value = "/checkout", method = RequestMethod.POST,
            produces = MediaType.APPLICATION_JSON_VALUE)
    protected String checkout(@RequestParam(name = "promocode", required = true) String promoCode, Model model, HttpSession session) {
        Gson gson = new Gson();
        Connection con = null;
        Statement stmt = null;
        ResultSet rs = null;

        String data = "";
        try {
            con = DatabaseConnection.getInstance().getConnection();
            stmt = con.createStatement();
            StringBuilder response = new StringBuilder();
            String query = String.format("select sum(quantity*price) as sm from cart");
            Integer sum = 0;
            Integer mod = 0;
            Integer sumPromo = 0;
            rs = stmt.executeQuery(query);
            while (rs.next()) {
                sum = rs.getInt("sm");
            }

            rs = stmt.executeQuery("select modifier from promo where promo='" + promoCode + "'");
            while (rs.next()) {
                mod = rs.getInt("modifier");
            }
            sumPromo = sum - sum * mod / 100;
            data = gson.toJson(new Cart("success", sum, sumPromo));

        } catch (SQLException sqlEx) {
            data = gson.toJson(new Result("error", sqlEx.getMessage()));
        } finally {

            try {
                con.close();
            } catch (SQLException se) {
            }
        }

        return data;

    }

    @RequestMapping(value = "/checkpromo", method = RequestMethod.POST,
            produces = MediaType.APPLICATION_JSON_VALUE)
    protected String checkpromo(@RequestParam(name = "promocode", required = true) String promoCode, Model model, HttpSession session) {
        Gson gson = new Gson();
        Connection con = null;
        Statement stmt = null;
        ResultSet rs = null;
        String error = "";
        String data = "";
        try {
            Integer modifier = 0;
            con = DatabaseConnection.getInstance().getConnection();
            stmt = con.createStatement();
            StringBuilder response = new StringBuilder();

            String query = String.format("SELECT modifier FROM `promo` WHERE `promo`='%s' LIMIT 1", promoCode);
            rs = stmt.executeQuery(query);

            while (rs.next()) {
                modifier = rs.getInt("modifier");
            }

            if (modifier == 0) {
                data = gson.toJson(new Result("error", "no promocode"));
            }
            if (modifier != 0) {
                data = gson.toJson(new Status("success", String.valueOf(modifier)));
            }

        } catch (SQLException sqlEx) {
            data = gson.toJson(new Result("error", sqlEx.getMessage()));

        } finally {
            try {
                con.close();
            } catch (SQLException se) {
            }

        }

        return data;

    }

}
