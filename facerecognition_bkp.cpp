#include "opencv2/core/core.hpp"
#include "opencv2/contrib/contrib.hpp"
#include "opencv2/highgui/highgui.hpp"
#include "opencv2/imgproc/imgproc.hpp"
#include "opencv2/objdetect/objdetect.hpp"
#include <iostream>
#include <fstream>
#include <sstream>
#include <string>
#include <pthread.h>
#include <cstdlib>
#include <ctime>

using namespace cv;
using namespace std;

time_t beg = time(0);
tm *ltm = localtime(&beg);
time_t end = time(0);
tm *ltm2 = localtime(&end);


int updated  = 0;


int main(int argc, const char *argv[]) {
   
    if (argc != 3) {
        cout << "usage: " << argv[0] << " /usr/local/share/OpenCV/haarcascades/haarcascade_frontalface_alt.xml 0" << endl;
        cout << "\t /usr/local/share/OpenCV/haarcascades/haarcascade_frontalface_alt.xml -- Path to the Haar Cascade for face detection." << endl;
        cout << "\t 0 -- The webcam device id to grab frames from." << endl;
        exit(1);
    }
    string fn_haar = string(argv[1]);
    int deviceId = atoi(argv[2]);
    
    CascadeClassifier haar_cascade;
    haar_cascade.load(fn_haar);
    
    VideoCapture cap(deviceId);
    
    if(!cap.isOpened()) {
        cerr << "Capture Device ID " << deviceId << "cannot be opened." << endl;
        return -1;
    }
    
    int framecount=0;
    Mat frame;
    int first=1;
    for(;;) {
			time(&beg);
			cap >> frame;
			framecount++;
  
			Mat original = frame.clone();
      
			Mat gray;
			cvtColor(original, gray, CV_BGR2GRAY);
     
			vector< Rect_<int> > faces;
			haar_cascade.detectMultiScale(gray, faces);
	
			for(int i = 0; i < faces.size(); i++) {
            
					Rect face_i = faces[i];
				
					Mat face = gray(face_i);
            
					Mat face_resized;
					cv::resize(face, face_resized, Size(222, 222), 1.0, 1.0, INTER_CUBIC);
            
					rectangle(original, face_i, CV_RGB(0, 255,0), 1);    
	     			string box_text = format("Detected faces");
	    	        cout<<difftime(beg, end)<<endl;
				    if( (difftime(beg, end) > 120) || (first==1) ){
						
							stringstream cmd1, cmd2, cmd3;
							cmd1<<"curl --data \"tag=flag&value=1&submit=Store \\a \\value\" http://vadistinydb.appspot.com/storeavalue &";
							string cmds1 = cmd1.str();	
							system(cmds1.c_str());
							system("php sms.php");

							string filename = "";
        
							stringstream  ssfn;
							ssfn<<"/home/vadiraja/Desktop/My_Projects/Inteli_Door_Project/bkp/"<<1900+ltm->tm_year<<"_"<<1+ltm->tm_mon<<"_"<<ltm->tm_mday<<"_"<<ltm->tm_hour<<"_"<<1+ltm->tm_min<<"_"<<ltm->tm_sec<<"_"<< ".png";
							filename = ssfn.str();
							imwrite(filename, frame);
	
							cmd2<<"curl -F \"fileToUpload=@"<<ssfn.str()<<"\" http://vadiedu.com/viewimg/upload.php &";
							string cmds2 = cmd2.str();	
							cout<<cmds2.c_str();
							system(cmds2.c_str());
				
							
							cmd3<<"curl --data \"message=Visit http://vadiedu.com/viewimg/viewimg.html to view the latest snapshot!! Also open your APP\" http://vadiedu.com/viewimg/contact_me.php &";
							string cmds3 = cmd3.str();	
							cout<<cmds3.c_str();
							system(cmds3.c_str());
		    
							first=0;
							time(&end);
							
					}		
                    int pos_x = std::max(face_i.tl().x - 10, 0);
					int pos_y = std::max(face_i.tl().y - 10, 0);
            
					putText(original, box_text, Point(pos_x, pos_y), FONT_HERSHEY_PLAIN, 1.0, CV_RGB(0,255,0), 2.0);
			}
        
        imshow("face_detectection", original);
       
        char key = (char) waitKey(20);
        
        if(key == 27)
            break;
    }
    return 0;
}
