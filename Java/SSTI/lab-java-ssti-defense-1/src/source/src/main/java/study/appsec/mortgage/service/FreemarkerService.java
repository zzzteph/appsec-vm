package study.appsec.mortgage.service;

import freemarker.template.Configuration;
import freemarker.template.Template;
import freemarker.template.TemplateException;
import freemarker.template.Version;
import org.springframework.stereotype.Service;

import java.io.IOException;
import java.io.StringReader;
import java.io.StringWriter;
import java.io.Writer;
import java.util.HashMap;
import java.util.Map;

@Service
public class FreemarkerService implements TemplateService {

    @Override
    public String compile(String name, String email, String phone, String service,
                          String productType, String valueFrom, String valueTo,
                          String message, String timestamp) {
        String template = String.join("<br>",
            "<!DOCTYPE html><html><body>",
            // =========================================================================================================
            "<h1>Thanks for using our services!</h1>",
            "<h4>Your request has been taken into account. You gave us the following data:</h4>",
            "<b>Your name:</b> ${name}",
            "<b>Your email:</b> ${email}",
            "<b>Your phone:</b> ${phone}",
            "<b>Chosen Service:</b> ${service}",
            "<b>Chosen Product Type:</b> ${productType}",
            "<b>Minimal value:</b> ${valueFrom}",
            "<b>Maximal value:</b> ${valueTo}",
            "<b>Your message:</b> " + message,
            "<b>Request Timestamp:</b> ${timestamp}",
            // =========================================================================================================
            "</body></html>"
        );
        Map<Object, Object> data = new HashMap<>();
        data.put("name", name);
        data.put("email", email);
        data.put("phone", phone);
        data.put("service", service);
        data.put("productType", productType);
        data.put("valueFrom", valueFrom);
        data.put("valueTo", valueTo);
        data.put("timestamp", timestamp);
        Writer out = new StringWriter();
        try {
            Template tpl = new Template("home", new StringReader(template), new Configuration(new Version(2, 3, 30)));
            tpl.process(data, out);
        } catch (TemplateException | IOException e) {
            return "Bad template :(";
        }
        return out.toString();
    }

}
