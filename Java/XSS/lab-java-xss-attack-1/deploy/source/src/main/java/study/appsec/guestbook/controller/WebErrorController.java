package study.appsec.guestbook.controller;

import study.appsec.guestbook.exception.ApplicationException;
import org.apache.commons.lang3.exception.ExceptionUtils;
import org.springframework.boot.web.servlet.error.ErrorController;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import javax.servlet.RequestDispatcher;
import javax.servlet.http.HttpServletRequest;

@Controller
public class WebErrorController implements ErrorController {

    private static final String ERROR_PATH = "/error";

    @RequestMapping(ERROR_PATH)
    public String error(HttpServletRequest request, Model model) {
        Integer statusCode = (Integer) request.getAttribute(RequestDispatcher.ERROR_STATUS_CODE);
        Exception exception = (Exception) request.getAttribute(RequestDispatcher.ERROR_EXCEPTION);
        model.addAttribute("error_code", statusCode);
        model.addAttribute("error_message", getMessage(exception));
        model.addAttribute("error_message_full", exception != null ? exception.getMessage() : null);
        model.addAttribute("is_app_error", isAppError(exception));
        return "pages/error";
    }

    private String getMessage(Exception exception) {
        if (exception == null) {
            return null;
        }
        Throwable rootCause = ExceptionUtils.getRootCause(exception);
        return rootCause.getMessage();
    }

    private boolean isAppError(Exception exception) {
        if (exception == null) {
            return false;
        }
        Throwable rootCause = ExceptionUtils.getRootCause(exception);
        return rootCause instanceof ApplicationException;
    }

    @Override
    public String getErrorPath() {
        return ERROR_PATH;
    }

}
