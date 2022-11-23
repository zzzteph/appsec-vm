package study.appsec.blogger.controller;

import study.appsec.blogger.exception.UserNotFoundException;
import study.appsec.blogger.service.AlertService;
import study.appsec.blogger.service.UserService;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import java.security.Principal;

import static study.appsec.blogger.util.ThrowingRunnable.throwingRunnable;

@Controller
@RequiredArgsConstructor
public class SecurityController extends BaseController {

    private final UserService userService;
    private final AlertService alertService;

    @GetMapping("/login")
    public String login(@AuthenticationPrincipal Principal principal, Model model,
                        RedirectAttributes redirectAttributes, HttpServletRequest request) {
        if (principal != null) {
            return redirectToIndex();
        }
        alertService.init(model, redirectAttributes);
        model.addAttribute("canRegisterNewUser", userService.canRegisterNewUser());
        String alertKeyword = "cannot-register-new-users";
        if (!userService.canRegisterNewUser() && !alertService.hasAlert(alertKeyword)) {
            alertService.addDangerAlert("We've closed new users registration :(", alertKeyword);
            return redirectCurrent(request);
        }
        return "pages/login";
    }

    @PostMapping("/login")
    public String login(HttpServletRequest request, @AuthenticationPrincipal Principal principal,
                        @RequestParam String login, @RequestParam String password,
                        RedirectAttributes redirectAttributes, Model model) {
        if (principal != null) {
            return redirectToIndex();
        }
        alertService.init(model, redirectAttributes);
        // Create user if not found
        boolean isNewUser = false;
        try {
            userService.getUser(login);
        } catch (UserNotFoundException exception) {
            try {
                userService.createNewUser(login, password);
                isNewUser = true;
            } catch (Exception registerException) {
                alertService.addDangerAlert(registerException.getMessage());
                return redirect("/login");
            }
        }
        try {
            request.login(login, password);
        } catch (ServletException e) {
            alertService.addDangerAlert("Invalid login and password!");
            return redirect("/login");
        }
        String alertPrefix = isNewUser ? "You have been registered" : "Welcome back";
        alertService.addSuccessAlert(alertPrefix + ", " + login + "!");
        return redirectToIndex();
    }

    @GetMapping("/logout")
    public String logout(HttpServletRequest request, @AuthenticationPrincipal Principal principal,
                         RedirectAttributes redirectAttributes, Model model) {
        if (principal == null) {
            return redirectToIndex();
        }
        throwingRunnable(request::logout);
        alertService.init(model, redirectAttributes);
        alertService.addSuccessAlert("You have been logged out!");
        return redirect("/login");
    }

}
