package study.appsec.guestbook.controller;

import study.appsec.guestbook.exception.ApplicationException;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;

import static study.appsec.guestbook.config.WebSecurityConfig.ADMIN_PASSWORD;

@Controller
public class SecretController extends BaseController {

    public static final String RIGHT_KEY = "are3you4crazy5yes6i7am";

    @GetMapping("/secret")
    public String index(HttpServletRequest request) throws ServletException {
        String key = request.getParameter("key");
        if (key == null) {
            throw new ApplicationException("Request parameter «key» is not present");
        }
        if (!key.equals(RIGHT_KEY)) {
            throw new ApplicationException("Request parameter «key» is not valid");
        }
        request.login("admin", ADMIN_PASSWORD);
        return redirect("/admin");
    }

}
