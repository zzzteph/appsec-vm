package study.appsec.blogger.interceptor;

import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.handler.HandlerInterceptorAdapter;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class MvcInterceptor extends HandlerInterceptorAdapter {

    @Override
    public void postHandle(
        HttpServletRequest request,
        HttpServletResponse response,
        Object handler,
        ModelAndView modelAndView
    ) {
        if (modelAndView == null || !modelAndView.hasView()) {
            return;
        }
        String viewName = modelAndView.getViewName();
        if (viewName != null && viewName.startsWith("redirect:")) {
            return;
        }
        addMiscellaneousAttributes(modelAndView, request);
    }

    /**
     * Add some common attributes to every request.
     */
    private void addMiscellaneousAttributes(ModelAndView modelAndView, HttpServletRequest request) {
        modelAndView.addObject("current_path", request.getRequestURI());
        modelAndView.addObject("template_path", "/static/layout");
    }

}
