module PageWrapper.Model exposing (..)

import PageWrapper.RightSideBar.Model as RightSideBar
import Pages.Dashboard.Model as Dashboard
import Pages.Tickets.Model as Tickets
import Pages.SingleTicket.Model as SingleTicket

type alias Model =
    { page : String
    , dashboardModel : Dashboard.Model
    , ticketsViewModel : Tickets.Model
    , ticketViewModel : SingleTicket.Model
    , rightSideBarModel : RightSideBar.Model
    }


model : Model
model =
    { page = "lol"
    , dashboardModel = Dashboard.model
    , ticketsViewModel = Tickets.model
    , ticketViewModel = SingleTicket.model
    , rightSideBarModel = RightSideBar.model
    }
