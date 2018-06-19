module Navbar.Model exposing (..)


type alias Model =
    { searchTxt : String
    , taskPanelClasses : String
    , notificationPanelClasses : String
    , userPanelClasses : String
    }

model : Model
model =
    { searchTxt = ""
    , taskPanelClasses = ""
    , notificationPanelClasses = ""
    , userPanelClasses = ""
    }
