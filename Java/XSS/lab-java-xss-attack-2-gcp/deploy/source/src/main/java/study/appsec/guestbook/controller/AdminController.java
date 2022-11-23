package study.appsec.guestbook.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

import javax.servlet.http.HttpServletRequest;

@Controller
public class AdminController extends BaseController {

    @GetMapping("/admin")
    public String index(HttpServletRequest request) {
        request.setAttribute("isInsideAdmin", true);
        return forward("/home");
    }

}
