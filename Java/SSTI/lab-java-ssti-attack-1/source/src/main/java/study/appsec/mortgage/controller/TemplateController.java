package study.appsec.mortgage.controller;

import study.appsec.mortgage.service.TemplateService;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import java.util.Calendar;

@Controller
@RequiredArgsConstructor
public class TemplateController {

    private final TemplateService templateService;

    @PostMapping("/")
    @ResponseBody
    public String handle(
        @RequestParam String name,
        @RequestParam String email,
        @RequestParam String phone,
        @RequestParam String service,
        @RequestParam String productType,
        @RequestParam String valueFrom,
        @RequestParam String valueTo,
        @RequestParam String message
    ) {
        String timestamp = Long.toString(Calendar.getInstance().getTimeInMillis());
        return templateService.compile(name, email, phone, service, productType,
            valueFrom, valueTo, message, timestamp);
    }

}
