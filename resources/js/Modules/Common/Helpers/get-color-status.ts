export const getColorStatus = (state: string | undefined) => {
    switch (state) {
        case "Reviewal Pending":
        case "Approval Pending":
            return "orange";
        case "Reviewal Accepted":
        case "Approval Accepted":
            return "green";
        case "Reviewal Rejected":
        case "Approval Rejected":
            return "red";
    }
};