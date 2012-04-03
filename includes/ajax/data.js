/*
   Deluxe Menu Data File
   Created by Deluxe Tuner v3.2
   http://deluxe-menu.com
*/


// -- Deluxe Tuner Style Names
var itemStylesNames=["Top Item",];
var menuStylesNames=["Top Menu",];
// -- End of Deluxe Tuner Style Names

//--- Common
var isHorizontal=1;
var smColumns=1;
var smOrientation=0;
var dmRTL=0;
var pressedItem=-2;
var itemCursor="default";
var itemTarget="_self";
var statusString="link";
var blankImage="data.files/blank.gif";
var pathPrefix_img="";
var pathPrefix_link="index.php?view=account&ac=earn&";

//--- Dimensions
var menuWidth="290px";
var menuHeight="29px";
var smWidth="";
var smHeight="";

//--- Positioning
var absolutePos=0;
var posX="10px";
var posY="10px";
var topDX=0;
var topDY=1;
var DX=-5;
var DY=0;
var subMenuAlign="left";
var subMenuVAlign="top";

//--- Font
var fontStyle=["normal 11px Trebuchet MS, Tahoma","normal 11px Trebuchet MS, Tahoma"];
var fontColor=["#000000","#FFFFFF"];
var fontDecoration=["none","none"];
var fontColorDisabled="#AAAAAA";

//--- Appearance
var menuBackColor="#D7D7D7";
var menuBackImage="";
var menuBackRepeat="repeat";
var menuBorderColor="#AAAAAA #242424 #242424 #AAAAAA";
var menuBorderWidth=1;
var menuBorderStyle="solid";

//--- Item Appearance
var itemBackColor=["#D7D7D7","#A0A0A0"];
var itemBackImage=["",""];
var beforeItemImage=["",""];
var afterItemImage=["",""];
var beforeItemImageW="";
var afterItemImageW="";
var beforeItemImageH="";
var afterItemImageH="";
var itemBorderWidth=2;
var itemBorderColor=["#D7D7D7","#BFBFBF #FFFFFF #BFBFBF #FFFFFF"];
var itemBorderStyle=["solid","solid"];
var itemSpacing=2;
var itemPadding="0px 5px 0px 10px";
var itemAlignTop="center";
var itemAlign="center";

//--- Icons
var iconTopWidth=16;
var iconTopHeight=16;
var iconWidth=16;
var iconHeight=16;
var arrowWidth=7;
var arrowHeight=7;
var arrowImageMain=["data.files/arrv_white.gif",""];
var arrowWidthSub=0;
var arrowHeightSub=0;
var arrowImageSub=["data.files/arr_black.gif","data.files/arr_white.gif"];

//--- Separators
var separatorImage="";
var separatorWidth="100%";
var separatorHeight="3px";
var separatorAlignment="left";
var separatorVImage="";
var separatorVWidth="3px";
var separatorVHeight="100%";
var separatorPadding="0px";

//--- Floatable Menu
var floatable=0;
var floatIterations=6;
var floatableX=1;
var floatableY=1;
var floatableDX=15;
var floatableDY=15;

//--- Movable Menu
var movable=1;
var moveWidth=12;
var moveHeight=20;
var moveColor="#DECA9A";
var moveImage="";
var moveCursor="move";
var smMovable=0;
var closeBtnW=15;
var closeBtnH=15;
var closeBtn="";

//--- Transitional Effects & Filters
var transparency="85";
var transition=30;
var transOptions="maxSquare=5";
var transDuration=350;
var transDuration2=200;
var shadowLen=3;
var shadowColor="#B1B1B1";
var shadowTop=0;

//--- CSS Support (CSS-based Menu)
var cssStyle=0;
var cssSubmenu="";
var cssItem=["",""];
var cssItemText=["",""];

//--- Advanced
var dmObjectsCheck=0;
var saveNavigationPath=1;
var showByClick=0;
var noWrap=1;
var smShowPause=200;
var smHidePause=1000;
var smSmartScroll=1;
var topSmartScroll=0;
var smHideOnClick=1;
var dm_writeAll=1;
var useIFRAME=0;
var dmSearch=0;

//--- AJAX-like Technology
var dmAJAX=0;
var dmAJAXCount=0;
var ajaxReload=0;

//--- Dynamic Menu
var dynamic=0;

//--- Keystrokes Support
var keystrokes=0;
var dm_focus=1;
var dm_actKey=113;

//--- Sound
var onOverSnd="";
var onClickSnd="";

var itemStyles = [
    ["itemWidth=92px","itemHeight=21px","itemBackImage=data.files/btn_orange.gif,data.files/btn_black_silver.gif","itemBorderWidth=0","fontStyle='normal 11px Tahoma','normal 11px Tahoma'","fontColor=#FFFFFF,#FFFFFF","showByClick=0"],
];
var menuStyles = [
    ["menuBackColor=transparent","menuBorderWidth=0","itemSpacing=1","itemPadding=0px 5px 0px 5px","smOrientation=undefined"],
];

var menuItems = [

    ["Paid to..","", "", "", "", "", "0", "", "", "", "", ],
        ["|Earn","", "", "", "", "", "", "", "", "", "", ],
            ["||Earn section","index.php?view=account&ac=earn&\".$url_variables.\"", "", "", "", "_self", "", "", "", "", "", ],
            ["||Paid to click","index.php?view=account&ac=click&\".$url_variables.\"", "", "", "", "_self", "", "", "", "", "", ],
            ["||Paid to read ads","index.php?view=account&ac=ptra&\".$url_variables.\"", "", "", "", "", "", "", "", "", "", ],
            ["||paid to signup","index.php?view=account&ac=ptsu&\".$url_variables.\"", "", "", "", "", "", "", "", "", "", ],
            ["||Click exchange","gpt.php?v=entry&type=ce&s=1&\".$url_variables.\"", "", "", "", "", "", "", "", "", "", ],
];

dm_init();