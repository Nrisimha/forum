module Sidebar.Model exposing(..)

import Sidebar.Menu exposing(..)

type alias Model =
    {menu: List MenuItem}


model : Model
model =
    { menu = menu
    }