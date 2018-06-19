module PageWrapper.Messages exposing (..)

import PageWrapper.RightSideBar.Messages as RightSideBar
import Pages.Dashboard.Messages as Dashboard
import Pages.Tickets.Messages as Tickets
import Pages.SingleTicket.Messages as SingleTicket

type Msg
    = NoOp
     | DashboardMessage Dashboard.Msg
     | TicketsViewMessage Tickets.Msg
     | TicketViewMessage SingleTicket.Msg
     | RightSideBarMessages RightSideBar.Msg