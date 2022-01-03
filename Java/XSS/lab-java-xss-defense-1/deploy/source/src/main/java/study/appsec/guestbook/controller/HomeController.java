package study.appsec.guestbook.controller;

import study.appsec.guestbook.service.CommentService;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

import javax.servlet.http.HttpServletRequest;

@Controller
@RequiredArgsConstructor
public class HomeController extends BaseController {

    private final CommentService commentService;

    @GetMapping("/home")
    public String index(Model model, HttpServletRequest request) {
        boolean forwardedFromAdminPage = request.getAttribute("isInsideAdmin") != null &&
            (boolean) request.getAttribute("isInsideAdmin");
        model.addAttribute("isInsideAdmin", forwardedFromAdminPage);
        model.addAttribute("comments", commentService.getLastFive());
        return "pages/home";
    }

}
