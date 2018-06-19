module PageWrapper.RightSideBar.Model exposing (..)


type alias User =
    { name : String, status : String, photo : String, statusClass : String }


type alias Model =
    { users : List User }


model : Model
model =
    { users =
        [ { name = "Arijit Sinh"
          , status = "Offline"
          , photo = "../plugins/images/users/arijit.jpg"
          , statusClass = "text-muted"
          }
        , { name = "Hritik Roshan"
          , status = "Offline"
          , photo = "../plugins/images/users/john.jpg"
          , statusClass = "text-warning"
          }
        , { name = "Pwandeep rajan"
          , status = "Offline"
          , photo = "../plugins/images/users/pawandeep.jpg"
          , statusClass = "text-success"
          }
        ]
    }
