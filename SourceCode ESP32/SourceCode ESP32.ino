#include <ESP8266WiFi.h>
#include <DHT.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

// DHT11 Settings
#define DHTPIN D1        // DHT11 di pin D1
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

// Relay Settings
#define RELAY_PIN D2     // Relay di pin D2

// WiFi credentials
const char* ssid = "a";
const char* password = "12345678";
const char* serverUrl = "https://00c0-182-1-112-125.ngrok-free.app/api";

void setup() {
    Serial.begin(115200);
    dht.begin();

    // Initialize Relay pin
    pinMode(RELAY_PIN, OUTPUT);
    digitalWrite(RELAY_PIN, LOW);  // Matikan relay saat awal

    // Connect to WiFi
    WiFi.begin(ssid, password);
    Serial.print("Connecting to WiFi...");
    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }
    Serial.println(" connected");

    // Cek status relay dari server saat awal nyala
    checkRelayStatus();
}

void loop() {
    // Baca sensor
    float  = dtemperatureht.readTemperature();
    float humidity = dht.readHumidity();

    if (isnan(temperature) || isnan(humidity)) {
        Serial.println("Failed to read from DHT sensor!");
    } else {
        Serial.print("Temperature: ");
        Serial.print(temperature);
        Serial.println(" °C");

        Serial.print("Humidity: ");
        Serial.print(humidity);
        Serial.println(" %");

        // Kirim data sensor ke server
        sendSensorData(temperature, humidity);

        // Cek status relay dari server
        checkRelayStatus();
    }

    delay(5000);  // Delay 5 detik
}

void sendSensorData(float temperature, float humidity) {
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        String url = String(serverUrl) + "/sensor-data";
        http.begin(url);
        http.addHeader("Content-Type", "application/json");

        String payload = "{\"temperature\":" + String(temperature, 1) + ",\"humidity\":" + String(humidity, 1) + "}";

        int httpResponseCode = http.POST(payload);

        if (httpResponseCode > 0) {
            Serial.print("Data sent! Response code: ");
            Serial.println(httpResponseCode);
        } else {
            Serial.print("Failed to send data. Error code: ");
            Serial.println(httpResponseCode);
        }
        http.end();
    } else {
        Serial.println("WiFi not connected");
    }
}

void checkRelayStatus() {
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        String url = String(serverUrl) + "/relay-control/latest";
        http.begin(url);
        int httpResponseCode = http.GET();

        if (httpResponseCode > 0) {
            String response = http.getString();
            StaticJsonDocument<200> doc;
            DeserializationError error = deserializeJson(doc, response);

            if (!error) {
                const char* state = doc["state"];

                if (strcmp(state, "on") == 0) {
                    digitalWrite(RELAY_PIN, HIGH);
                    Serial.println("Relay ON");
                } else if (strcmp(state, "off") == 0) {
                    digitalWrite(RELAY_PIN, LOW);
                    Serial.println("Relay OFF");
                }
            } else {
                Serial.print("Failed to parse JSON: ");
                Serial.println(error.f_str());
            }
        } else {
            Serial.print("Error code getting relay status: ");
            Serial.println(httpResponseCode);
        }
        http.end();
    } else {
        Serial.println("WiFi not connected");
    }
}
