package application

import (
	"fmt"
	"infrastructure/consumer"
)

type NarratorService struct {
	Consumer   Consumer
	LastName    string
	TotalLeaves int
	LeavesTaken int
}

func (e Employee) LeavesRemaining() {
	fmt.Printf("%s %s has %d leaves remaining\n", e.FirstName, e.LastName, (e.TotalLeaves - e.LeavesTaken))
}
