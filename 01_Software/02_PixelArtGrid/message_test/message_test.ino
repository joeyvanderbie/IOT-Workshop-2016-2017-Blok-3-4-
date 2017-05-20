#include <OpenWiFi.h>

#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiManager.h>

// I should throw all of this into a config file
#define DEBUG_MODE
#define BUTTON_PIN  D1
#define BUTTONLOW_PIN D0
#define PROJECT_SHORT_NAME "ICU"
#define SERVER_URL "http://oege.ie.hva.nl/~marcelp001/icu"
#define CONFIG_SSID "icu"
#define BACKUP_SSID "VGV75198714B3"
#define BACKUP_PASSWORD "wNSY4GMMpzPP"
#define REQUEST_DELAY 2000


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

//  chipID = generateChipID();
  //printDebugMessage(String("Last 2 bytes of chip ID: ") + chipID);
}

void loop()
{
  //Check for button press
  if (digitalRead(BUTTON_PIN) == LOW)
  {
    sendButtonPress();
    delay(250);
  }

  //Every requestDelay, send a request to the server
  if (millis() > oldTime + REQUEST_DELAY)
  {
    requestMessage();
    oldTime = millis();
  }
}

// api:ss inserts a 1 into the database
// api:rs checks if there is a 1 in the database, column test_message ; row message(TEXT)

void sendButtonPress(){
// send some stuff to API to change something in the DB
printDebugMessage("Sending button press to server");
  HTTPClient http;
  String site =  serverURL + "/api.php?t=ss";
  http.begin(site);
 Serial.println(site);
  uint16_t httpCode = http.GET();
  http.end();
}

void requestMessage(){
// ask the API if there is something in the DB, and recieve the meme supreme message
// in the API delete the thing from the DB so it doesn't keep on recieving
 HTTPClient http;
  String requestString = serverURL + "/api.php?t=rs"; // look up api index, action is 
  http.begin(requestString);
  int httpCode = http.GET();
  
  if (httpCode == 200)
  {
    String response;
    response = http.getString();

    if (response == "-1") // this part still isn't working correctly, unless I do: echo $response;
    {
      // I can never get here, buggy stuff
    printDebugMessage("There are no messages waiting in the queue");
    }
    else
    {
      // tells you that you have got the chip or the dip lmao FK I'M HILARIOUS
      String thing = response.substring(0, 5);
      printDebugMessage(response);
    }
  }
    else {
    //  ESP.reset();
      Serial.println("Resetting cause everything broke");
    } 
    http.end();
    }
