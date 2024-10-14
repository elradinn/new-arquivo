import { Badge } from "@mantine/core";

interface StateBadgeProps {
    state: string;
}

const StateBadge: React.FC<StateBadgeProps> = ({ state }) => {
    const getColor = (state: string) => {
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
            default:
                return "gray";
        }
    };

    return <Badge color={getColor(state)} variant="light">{state}</Badge>;
};

export default StateBadge;