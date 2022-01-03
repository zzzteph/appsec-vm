package study.appsec.mortgage.service;

public interface TemplateService {

    String compile(
        String name,
        String email,
        String phone,
        String service,
        String productType,
        String valueFrom,
        String valueTo,
        String message,
        String timestamp
    );

}
