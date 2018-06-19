module Messages exposing (..)

import Navbar.Messages
import Sidebar.Messages
import PageWrapper.Messages
import Navigation exposing (Location)

import RemoteData exposing (WebData)
import Models exposing(User)
import Pages.Tickets.Model
import Pages.SingleTicket.Model


type Msg
    = NavBarMessages Navbar.Messages.Msg
    | SideBarMessages Sidebar.Messages.Msg
    | PageWrapperMessages PageWrapper.Messages.Msg
    | OnLocationChange Location
    | OnFetchUser (WebData User)
    | OnFetchTickets (WebData (List Pages.Tickets.Model.Ticket))
    | OnFetchTicket (WebData Pages.SingleTicket.Model.Ticket)
