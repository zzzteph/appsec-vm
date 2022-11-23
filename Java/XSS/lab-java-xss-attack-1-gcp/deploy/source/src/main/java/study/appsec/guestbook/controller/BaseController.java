package study.appsec.guestbook.controller;

import study.appsec.guestbook.exception.ApplicationException;
import lombok.RequiredArgsConstructor;

import javax.servlet.http.HttpServletRequest;
import java.security.Principal;

@RequiredArgsConstructor
public abstract class BaseController {

    protected String redirect(String path) {
        return "redirect:" + path;
    }

    protected String forward(String path) {
        return "forward:" + path;
    }

    protected String redirectToIndex() {
        return redirect("/");
    }

    protected String redirectBack(HttpServletRequest request) {
        return redirectBack(request, null);
    }

    protected String redirectCurrent(HttpServletRequest request) {
        return redirect(request.getRequestURI());
    }

    protected String redirectBack(HttpServletRequest request, String requestParameters) {
        String url = request.getHeader("Referer");
        if (requestParameters != null && !url.contains(requestParameters)) {
            String divider = !url.contains("?") ? "?" : "&";
            url = url + divider + requestParameters;
        }
        return redirect(url);
    }

    protected void ensureAuth(Principal principal) {
        if (principal == null) {
            throw new ApplicationException("You must login first.");
        }
    }

}
