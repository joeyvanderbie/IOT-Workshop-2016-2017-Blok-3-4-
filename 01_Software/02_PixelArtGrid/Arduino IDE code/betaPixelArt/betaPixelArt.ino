#include <OpenWiFi.h>

#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiManager.h>

// I should throw all of this into a config file
#define DEBUG_MODE
#define BUTTON_PIN  D1
#define BUTTONLOW_PIN D0
#define PROJECT_SHORT_NAME "ICU"
#define SERVER_URL "http://oege.ie.hva.nl/~palr001/icu"
#define CONFIG_SSID "icu"
#define BACKUP_SSID "VGV75198714B3"
#define BACKUP_PASSWORD "wNSY4GMMpzPP"
#define REQUEST_DELAY 500

boolean isReady = false;
String internalTimer;
String externalTimer;
int intTimer = 0;
int exTimer = 99999999;


int oldTime = 0;
String ChipID; // to be later implemented with a change in the api
String serverURL = SERVER_URL;
OpenWiFi hotspot;

void printDebugMessage(String message){
#ifdef DEBUG_MODE
Serial.println(String(PROJECT_SHORT_NAME)+ ":" + message);
#endif
}

void setup()
{
  
  pinMode(BUTTONLOW_PIN, OUTPUT);

  digitalWrite(BUTTONLOW_PIN, LOW);

  Serial.begin(115200); Serial.println("");

  WiFiManager wifiManager;
  int counter = 0;

  pinMode(BUTTON_PIN, INPUT_PULLUP);

  while (digitalRead(BUTTON_PIN) == LOW)
  {
    counter++;
    delay(10);

    if (counter > 500)
    {
      wifiManager.resetSettings();
      printDebugMessage("Remove all wifi settings!");
      ESP.reset();
    }
  }
  hotspot.begin(BACKUP_SSID, BACKUP_PASSWORD);

  ChipID = generateChipID();
  printDebugMessage(String("Last 2 bytes of chip ID: ") + ChipID);
}

void loop()
{
  //Check for button press

  //Every requestDelay, send a request to the server
  if (millis() > oldTime + REQUEST_DELAY)
  {
    if(!isReady){
    getColor();
    isSetupReady();
    } else {
      // is internal epoch == api call to current epoch?
      Serial.println("setup complete");
      isTimerSynced();
      Serial.println(intTimer);
      Serial.println(exTimer);
      if(intTimer <= exTimer){
        Serial.println("LIGHTS SHOULD GO ON NOW");
        intTimer = 0;
        isReady = false;
      }
    }
  oldTime = millis();
  }
}

    String generateChipID()
{
  String chipIDString = String(ESP.getChipId() & 0xffff, HEX);

  chipIDString.toUpperCase();
  while (chipIDString.length() < 4)
    chipIDString = String("0") + chipIDString;

  return chipIDString;
}


    //ask for color
    void getColor(){
      // request color from api for this chip id
      HTTPClient http;
  String requestString = serverURL + "/api4.php?t=gc&c="+ ChipID; // look up api index, action is 
  http.begin(requestString);
  int httpCode = http.GET();
  
  if (httpCode == 200)
  {
    String response;
    response = http.getString();

    if (response == "-1")
    {
      // I can never get here, buggy stuff
    printDebugMessage("There are no messages waiting in the queue");
    }
    else
    {
      // string color = response = gonna be the color you receiver for you chipid
      String color = response.substring(0, 5);
     // save String color into a variable color
      printDebugMessage(response);
    }
  }
    }
    
    //ask if ready
    void isSetupReady(){
    // ask the api is there is a value in ready?
          HTTPClient http;
  String requestString = serverURL + "/api4.php?t=grdy";
  http.begin(requestString);
  int httpCode = http.GET();
  
  if (httpCode == 200)
  {
    String response;
    response = http.getString();
    if (response == "-1")
    {
    printDebugMessage("There are no messages waiting in the queue");
    }
    else {
      int firstComma = response.indexOf(',');
      // timer
      String ready = response.substring(0, 1); // if 1 it is ready
      if (ready == "1"){
      internalTimer = response.substring(firstComma + 1, response.length());
      intTimer = internalTimer.toInt();
      isReady = true;
      }
      Serial.println(response);
    }
  }
    
    }
    
    // sync timer to server timer
    void isTimerSynced(){
      
            HTTPClient http;
            // request timer from server
                  // epochtime save in variable, then in isTimerSynced ask if internal epochtime == server epochtime
  String requestString = serverURL + "/Pixel_Art_Timer.php";
  http.begin(requestString);
  int httpCode = http.GET();
  
  if (httpCode == 200)
  {
    String response;
    response = http.getString();

    if (response == "-1")
    {
      // I can never get here, buggy stuff
    printDebugMessage("There are no messages waiting in the queue");
    } else {
      externalTimer = response.substring(0, response.length());
      exTimer = externalTimer.toInt();
    }
  }
      
    }

