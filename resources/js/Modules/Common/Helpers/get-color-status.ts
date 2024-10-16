export const getColorStatus = (state: string | undefined) => {
    switch (state) {
        case "Reviewal Pending":
            return "yellow";
        case "Reviewal Accepted":
            return "green";
        case "Reviewal Rejected":
            return "red";
        case "Approval Pending":
            return "blue";
        case "Approval Accepted":
            return "teal";
        case "Approval Rejected":
            return "orange";
    }
};