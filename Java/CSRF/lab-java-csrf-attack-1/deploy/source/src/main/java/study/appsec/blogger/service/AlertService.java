package study.appsec.blogger.service;

import study.appsec.blogger.model.Alert;
import lombok.RequiredArgsConstructor;
import org.springframework.context.annotation.Primary;
import org.springframework.stereotype.Service;
import org.springframework.ui.Model;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.ArrayList;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

@Service
@Primary
@RequiredArgsConstructor
public class AlertService {

    private static final String ALERTS_KEY = "app_alerts";

    private Model model;
    private RedirectAttributes redirectAttributes;
    private List<Alert> alerts;

    public void init(Model model, RedirectAttributes redirectAttributes) {
        this.model = model;
        this.redirectAttributes = redirectAttributes;
        alerts = parseAlerts();
    }

    public void addSuccessAlert(String text, String keyword) {
        addAlert(text, Alert.STYLE_SUCCESS, keyword);
    }

    public void addSuccessAlert(String text) {
        addSuccessAlert(text, null);
    }

    public void addInfoAlert(String text, String keyword) {
        addAlert(text, Alert.STYLE_INFO, keyword);
    }

    public void addInfoAlert(String text) {
        addInfoAlert(text, null);
    }

    public void addWarningAlert(String text, String keyword) {
        addAlert(text, Alert.STYLE_WARNING, keyword);
    }

    public void addWarningAlert(String text) {
        addWarningAlert(text, null);
    }

    public void addDangerAlert(String text, String keyword) {
        addAlert(text, Alert.STYLE_DANGER, keyword);
    }

    public void addDangerAlert(String text) {
        addDangerAlert(text, null);
    }

    public boolean hasAlert(String keyword) {
        return alerts.stream()
            .filter(alert -> alert.getKeyword() != null)
            .anyMatch(alert -> alert.getKeyword().equals(keyword));
    }

    @SuppressWarnings("unchecked")
    private List<Alert> parseAlerts() {
        Map<String, Alert> result = new LinkedHashMap<>();
        parseAlertsFromArray(result, (List<Alert>) model.getAttribute(ALERTS_KEY));
        parseAlertsFromArray(result, (List<Alert>) redirectAttributes.getFlashAttributes().get(ALERTS_KEY));
        return new ArrayList<>(result.values());
    }

    private void parseAlertsFromArray(Map<String, Alert> result, List<Alert> array) {
        if (array == null) {
            return;
        }
        array.forEach(alert -> result.put(alert.getKeyword(), alert));
    }

    private void addAlert(String text, String style, String keyword) {
        ensureServiceInitialized();
        alerts.add(new Alert(keyword, text, style));
        redirectAttributes.addFlashAttribute(ALERTS_KEY, alerts);
    }

    private void ensureServiceInitialized() {
        if (redirectAttributes == null) {
            throw new RuntimeException("Init this service first.");
        }
    }

}
