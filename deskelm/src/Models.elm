module Models exposing (..)

import Navbar.Model
import PageWrapper.Model
import Sidebar.Model
import Routing exposing(Route)
import RemoteData exposing (WebData)


type alias Model =
    { user : WebData User
    , navBarModel : Navbar.Model.Model
    , sideBarModel : Sidebar.Model.Model
    , pageWrapperModel : PageWrapper.Model.Model
    , route: Route
    }


type alias User =
    { id : Int, name : String, email : String }


model : Route -> Model
model route =
    { user = RemoteData.Loading
    , navBarModel = Navbar.Model.model
    , sideBarModel = Sidebar.Model.model
    , pageWrapperModel = PageWrapper.Model.model
    , route = route
    }
